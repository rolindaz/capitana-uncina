<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\ProjectTranslation;
use App\Models\Yarn;
use App\Models\Colorway;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Craft;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        /* definisco l'array di parametri accettati per l'ordinamento dei progetti */
        $allowedSorts = [
            'name',
            'category',
            'created_at',
            'updated_at',
        ];

        /* verifico che il parametro per l'ordinamento presente nella request sia uno di quelli che ho definito io, sennò di default va comunque a data di creazione */
        $sort = $request->query('sort', 'created_at');
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        /* Stessa cosa per la direzione dell'ordinamento (ascendente o discendente) */

        $direction = $request->query('direction', 'desc');
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        /* dd($request); */

        /* Salvo la lingua corrente */
        $locale = app()->getLocale();

        /* Salvo la selezione di relazioni + Progetti */
        $query = Project::query()->with([
            'translation',
            'category.translation'
        ]);

        /* Imposto le regole per decidere cosa mostrare, in base alla lingua corrente e all'ordinamento e direzione richiesti */
        if ($sort === 'name') {
            $query->orderBy(
                ProjectTranslation::query()
                    ->select('name')
                    ->whereColumn('project_id', 'projects.id')
                    ->where('locale', $locale)
                    ->limit(1),
                $direction
            );
        } elseif ($sort === 'category') {
            $query->orderBy(
                CategoryTranslation::query()
                    ->select('name')
                    ->whereColumn('category_id', 'projects.category_id')
                    ->where('locale', $locale)
                    ->limit(1),
                $direction
            );
        } else {
            $query->orderBy($sort, $direction);
        }

        /* Salvo la selezione dei progetti in una variabile "paginabile", con 12 elementi per pagina e che si trasporti la query da una pagina all'altra, così non mi perdo cose tipo ordinamento ecc. */
        $projects = $query
            ->paginate(9)
            ->withQueryString();

        return view('admin.projects.index', compact('projects', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $yarns = Yarn::all();
        $colorways = Colorway::all();
        $categories = Category::query()
            ->with('translation')
            ->get();
        $crafts = Craft::query()
            ->with('translation')
            ->get();
        $sizes = config('data.projects.sizes');
        $status = config('data.projects.status');

        return view('admin.projects.create', compact([
            'categories',
            'sizes',
            'yarns',
            'colorways',
            'status',
            'crafts'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);

        /* Convalido i dati */
        $v_data = $request->validate([
            'name' => ['required', 'string'],
            'craft_ids' => ['required', 'array'],
            'craft_ids.*' => ['exists:crafts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],

            'status' => ['required', 'string'],
            'started' => ['nullable', 'date'],
            'completed' => ['nullable', 'date'],
            'execution_time' => ['nullable', 'numeric', 'min:0'],

            'designer_name' => ['nullable', 'string'],
            'pattern_name' => ['nullable', 'string'],
            'pattern_url' => ['nullable', 'url'],

            'size' => ['nullable', 'string'],
            'yarns' => ['nullable', 'array'],
            'yarns.*.yarn_id' => ['required', 'exists:yarns,id'],
            'yarns.*.colorway_id' => ['nullable', 'sometimes', 'exists:colorways,id'],
            'yarns.*.quantity' => ['nullable', 'numeric', 'min:0'],
            'destination_use' => ['nullable', 'string'],
            'notes' => ['nullable', 'string']
        ]);

        //dd($v_data);

        /* Creo una nuova istanza del progetto, in cui inserisco solo i valori pertinenti al modello Project - gli altri si riferiscono a ProjectTranslation e vanno attribuiti tramite la relazione */
        $newProject = Project::create([
            'designer_name' => $v_data['designer_name'],
            'pattern_name' => $v_data['pattern_name'],
            'pattern_url' => $v_data['pattern_url'],
            'category_id' => $v_data['category_id'],
            'started' => $v_data['started'],
            'completed' => $v_data['completed'],
            'execution_time' => $v_data['execution_time'],
            'size' => $v_data['size']
        ]);

        /* Salvo l'immagine, se fornita */
        if (array_key_exists('image_path', $v_data)) {
            // dump("l'immagine c'è");
            $img_url = Storage::putFile('projects', $v_data['image_path']);
            $newProject->image_path = $img_url;
            $newProject->save();
        }

        /* Mi prendo la locale e genero lo slug */
        $locale = app()->getLocale();
        $slug = Str::slug($v_data['name']);

        /* Creo una nuova istanza di projectTranslation attraverso la relazione translation() del progetto appena creato */
        $newProject->translation()->create([
            'locale' => $locale,
            'name' => $v_data['name'],
            'notes' => $v_data['notes'],
            'status' => $v_data['status'],
            'destination_use' => $v_data['destination_use'],
            'slug' => $slug,
        ]);

        /* Se fornito, ciclo l'array di filati utilizzati per salvare le rispettive voci in una nuova istanza di ProjectYarn a partire dalla relazione yarns() del progetto appena creato */
        foreach ($v_data['yarns'] ?? [] as $usedYarnData) {
            $newProject->yarns()->attach(
                $usedYarnData['yarn_id'],
                [
                    'colorway_id' => $usedYarnData['colorway_id'] ?? null,
                    'quantity' => $usedYarnData['quantity'] ?? null
                ]
            );
        }

        /* Se fornito, uso l'array di id delle tecniche per creare nuove righe nella pivot craftProject */
        if (!empty($v_data['craft_ids'])) {
            $newProject->crafts()->attach($v_data['craft_ids']);
        }

        /* Torno alla index, dove vedo il mio nuovo progetto nella lista */
        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load([
            'category',
            'crafts',
            'projectYarns.colorway'
        ]);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $yarns = Yarn::all();
        $colorways = Colorway::all();
        $project->load([
            'translation',
            'category.translation',
            'crafts.translation',
            'projectYarns.colorway'
        ]);
        $categories = Category::query()
            ->with('translation')
            ->get();
        $crafts = Craft::query()
            ->with('translation')
            ->get();
        $status = config('data.projects.status');
        $sizes = config('data.projects.sizes');

        return view('admin.projects.edit', compact([
            'project',
            'categories',
            'crafts',
            'status',
            'sizes',
            'yarns',
            'colorways'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        /* dd($request); */

        /* Convalido i dati */
        $v_data = $request->validate([
            'name' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'craft_ids' => ['required', 'array'],
            'craft_ids.*' => ['exists:crafts,id'],

            'status' => ['required', 'string'],
            'started' => ['nullable', 'date'],
            'completed' => ['nullable', 'date'],
            'execution_time' => ['nullable', 'numeric', 'min:0'],

            'designer_name' => ['nullable', 'string'],
            'pattern_name' => ['nullable', 'string'],
            'pattern_url' => ['nullable', 'url'],

            'size' => ['nullable', 'string'],
            'yarns' => ['nullable', 'array'],
            'yarns.*.yarn_id' => ['required', 'exists:yarns,id'],
            'yarns.*.colorway_id' => ['nullable', 'sometimes', 'exists:colorways,id'],
            'yarns.*.quantity' => ['nullable', 'numeric', 'min:0'],
            'destination_use' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],

            'image_path' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
        ]);

        /* dd($v_data); */

        /* Se il valore di Stato è diverso da "Completato", alla data di completamento e al tempo totale di lavoro va attribuito in automatico un valore nullo */
        if (!in_array($v_data['status'], ['Completed', 'Completato'], true)) {
            $v_data['completed'] = null;
            $v_data['execution_time'] = null;
        }

        /* Aggiorno tutti i campi del progetto con i valori forniti */

        $project->category_id = $v_data['category_id'];
        $project->started = $v_data['started'] ?? null;
        $project->completed = $v_data['completed'] ?? null;
        $project->execution_time = $v_data['execution_time'] ?? ($project->execution_time ?? null);
        $project->designer_name = $v_data['designer_name'] ?? null;
        $project->pattern_name = $v_data['pattern_name'] ?? null;
        $project->pattern_url = $v_data['pattern_url'] ?? null;
        $project->size = $v_data['size'] ?? null;

        /* Aggiornamento immagine */
        if ($request->hasFile('image_path')) {
            if (!empty($project->image_path)) {
                Storage::delete($project->image_path);
            }
            $project->image_path = Storage::putFile('projects', $v_data['image_path']);
        }

        $project->save();

        /* Prendo la locale corrente e genero lo slug */
        $locale = app()->getLocale();
        $slug = Str::slug($v_data['name']);

        /* Aggiorno o creo - se non esiste già - la traduzione del progetto per la locale corrente e inserisco i campi pertinenti */
        $project->project_translations()->updateOrCreate(
            [
                'locale' => $locale,
                'project_id' => $project->id,
            ],
            [
                'name' => $v_data['name'],
                'notes' => $v_data['notes'],
                'destination_use' => $v_data['destination_use'],
                'status' => $v_data['status'],
                'slug' => $slug,
            ]
        );

        /* Sincronizzo le tecniche */
        $project->crafts()->sync($v_data['craft_ids']);

        /* Ricostruisco le righe della tabella project_yarn collegate al progetto corrente */
        $project->yarns()->detach();
        foreach ($v_data['yarns'] ?? [] as $yarnData) {
            $project->yarns()->attach(
                $yarnData['yarn_id'],
                [
                    'colorway_id' => $yarnData['colorway_id'] ?? null,
                    'quantity' => $yarnData['quantity'] ?? null,
                ]
            );
        }

        /* Scollego la relazione precedente, che Eloquent trattiene. Così la prossima volta che voglio la translation di questo progetto verrà generata una nuova query che prende le informazioni aggiornate, invece di quelle vecchie */
        $project->unsetRelation('translation');

        /* Torno alla show, dove visualizzo le informazioni aggiornate */
        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Project updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {   
        /* Elimino l'immagine collegata al progetto */
        if (!empty($project->image_path)) {
            Storage::delete($project->image_path);
        }

        /* Elimino tutte le relazioni del progetto */
        $project->crafts()->detach();
        $project->projectYarns()->delete();
        $project->project_translations()->delete();

        /* DeleteOrFail lancia un errore in caso di fallimento, a differenza di delete(), per cui posso accorgermi subito se qualcosa è andato storto */
        $project->deleteOrFail();

        /* Torno alla index */
        return redirect()->route('projects.index');
    }
}