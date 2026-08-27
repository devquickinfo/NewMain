@extends('frontend.layout.applayout')
@section('title', 'School Details')
@section('content')
<style>
    .sample-image-wrapper {
    width: 100%;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #f5f5f5;
    border-radius: 5px;
    }

    .sample-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- <div class="col-sm-6">
                    <h1>Card Sample</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"> Card Sample</li>
                    </ol>
                </div> -->
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <form action="{{ route('upload-sample.destroyAll') }}"
                            method="POST"
                            class="ml-3">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> All
                            </button>
                        </form>

                        @if(session('role') !== 'school' && !session('viewing_school'))

                            <div class="ml-auto">
                                <a href="{{ route('upload-samples.create') }}"
                                class="btn btn-primary">
                                    Add Samples
                                </a>
                            </div>

                        @elseif(session('role') === 'school' || session('viewing_school'))

                            <div class="ml-auto">
                                <a href="{{ route('upload-samples.create') }}"
                                class="btn btn-primary">
                                    Upload Your Own Sample
                                </a>
                            </div>

                            <form action="{{ route('selected-samples.store') }}"
                                method="POST"
                                class="ml-2">
                                @csrf

                                <input type="hidden" name="sample_id" id="selected-sample-id">

                                <button type="submit" class="btn btn-primary">
                                    Save Samples
                                </button>
                            </form>

                        @endif

                    </div>
                </div>
                <div class="card-body">
                    @if(session('role') === 'school')
                        {{-- SCHOOL --}}
                        {{-- TABS --}}
                        <ul class="nav nav-tabs mb-4"
                            id="sampleTabs"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                id="default-tab"
                                data-toggle="tab"
                                href="#default-samples"
                                role="tab">
                                    Default Samples
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                id="own-tab"
                                data-toggle="tab"
                                href="#own-samples"
                                role="tab">
                                    My Uploaded Samples
                                </a>
                            </li>
                        </ul>
                        {{-- TAB CONTENT --}}
                        <div class="tab-content">
                            {{-- DEFAULT SAMPLES --}}
                            <div class="tab-pane fade show active"
                                id="default-samples"
                                role="tabpanel">
                                <div class="row">
                                    @foreach($defaultSamples as $all)
                                        @include('schools.partials.sample-card', [
                                            'all' => $all
                                        ])
                                    @endforeach
                                </div>
                            </div>
                            {{-- MY UPLOADED SAMPLES --}}
                            <div class="tab-pane fade"
                                id="own-samples"
                                role="tabpanel">
                                <div class="row">
                                    @foreach($ownSamples as $all)
                                        @include('schools.partials.sample-card', [
                                            'all' => $all
                                        ])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- ADMIN --}}
                        <div class="row">
                            @foreach($alls as $all)
                                @include('schools.partials.sample-card', [
                                    'all' => $all
                                ])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
