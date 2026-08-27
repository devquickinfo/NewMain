@extends('frontend.layout.applayout')

@section('title', 'ID Card Templates')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
     
      </div>
    </div>
</section>
<div class="content-wrapper">

    <section class="content-header">

        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center">

                <h1>
                    ID Card Templates
                </h1>

                <a
                    href="{{ route('id-card-templates.create') }}"
                    class="btn btn-primary"
                >
                    <i class="fas fa-plus mr-1"></i>
                    Create Template
                </a>

            </div>

        </div>

    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @forelse($templates as $template)

                    <div class="col-md-4 col-lg-3">

                        <div class="card">

                            <div class="card-body p-2">

                                <img
                                    src="{{ asset('storage/' . $template->image_path) }}"
                                    class="img-fluid"
                                    alt="{{ $template->name }}"
                                >

                            </div>


                            <div class="card-footer">

                                <strong>
                                    {{ $template->name }}
                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ $template->fields_count }}
                                    fields

                                    @if($template->is_active)

                                        <span class="badge badge-success ml-1">
                                            Active
                                        </span>

                                    @endif

                                </small>


                                <div class="mt-2">

                                    <a
                                        href="{{ route('id-card-templates.designer', $template->id) }}"
                                        class="btn btn-primary btn-sm"
                                    >
                                        <i class="fas fa-edit"></i>
                                        Design
                                    </a>

                                    <a
                                        href="{{ route('id-card-templates.edit', $template->id) }}"
                                        class="btn btn-secondary btn-sm"
                                    >
                                        <i class="fas fa-cog"></i>
                                        Edit
                                    </a>

                                    @if($template->fields_count > 0)

                                        <a
                                            href="{{ route('id-card-templates.students', $template->id) }}"
                                            class="btn btn-success btn-sm"
                                        >
                                            <i class="fas fa-id-card"></i>
                                            Generate
                                        </a>

                                    @endif


                                    @if(!$template->is_active)

                                        <form
                                            action="{{ route('id-card-templates.activate', $template->id) }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf

                                            <button
                                                class="btn btn-success btn-sm"
                                            >
                                                Activate
                                            </button>

                                        </form>

                                    @endif


                                    <form
                                        action="{{ route('id-card-templates.destroy', $template->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit=""
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="card">

                            <div class="card-body text-center py-5">

                                <i
                                    class="fas fa-id-card"
                                    style="font-size:60px;color:#ccc;"
                                ></i>

                                <h4 class="mt-3">
                                    No ID Card Templates
                                </h4>

                                <p class="text-muted">
                                    Upload your first ID card design.
                                </p>

                                <a
                                    href="{{ route('id-card-templates.create') }}"
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-plus mr-1"></i>
                                    Create Template
                                </a>

                            </div>

                        </div>

                    </div>

                @endforelse

            </div>


            <div class="mt-3">

                {{ $templates->links() }}

            </div>

        </div>

    </section>

</div>

@endsection