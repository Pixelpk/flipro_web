<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
</div>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Home</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Contracts</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contracts</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if($project == 'project')
                                    @livewire('tables.project-contract-table', ['params' => [
                                        'user_id' => $user->id,
                                    ]])
                                    @else
                                    @livewire('tables.project-contract-table', ['params' => [
                                        'user_id' => $user->id,
                                        'withoutProject' => 'withoutProject',
                                    ]])
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>