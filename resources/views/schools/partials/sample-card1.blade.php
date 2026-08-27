<div class="col-md-3 mb-4">

    <div class="card h-100">

        {{-- CARD HEADER --}}
        <div class="card-header bg-primary text-white">

            <div class="d-flex align-items-center">

                <h3 class="card-title mb-0 flex-grow-1">

                    @if(session('role') === 'school' || session('viewing_school'))

                        <label class="mb-0 d-flex align-items-center"
                               style="cursor:pointer;">

                            <input
                                type="radio"
                                name="sample_id"
                                value="{{ $all->id }}"
                                class="sample-radio mr-2"
                                {{ $selectedSample && $selectedSample->sample_id == $all->id ? 'checked' : '' }}
                            >

                            <span>
                                {{ $all->name }}
                            </span>

                        </label>

                    @else

                        {{ $all->name }}

                    @endif

                </h3>


                {{-- DELETE --}}
                @if(
                    session('role') !== 'school'
                    ||
                    $all->school_id == Auth::user()->school_id
                )

                    <form
                        action="{{ route('upload-samples.destroy', $all->id) }}"
                        method="POST"
                        class="ml-2">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-sm btn-danger">

                            <i class="fas fa-trash"></i>

                        </button>

                    </form>

                @endif

            </div>

        </div>


        {{-- CARD BODY --}}
        <div class="card-body">

            @if($all->caption)

                <p class="mb-2 text-muted">

                    {{ $all->caption }}

                </p>

            @endif


            <div class="sample-image-wrapper">

                <img
                    src="{{ asset('storage/' . $all->file_path) }}"
                    alt="{{ $all->name }}"
                    class="sample-image"
                >

            </div>

        </div>

    </div>

</div>