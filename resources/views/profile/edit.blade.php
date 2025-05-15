@extends('layouts.app')

@section('content')
<div class="container px-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <h2 class="text-center mb-4">Edit Profil</h2>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-3 d-flex flex-column align-items-center">
                    <div class="profile-image-container" style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%; position: relative;">
                        @if(auth()->user()->profile_photo)
                            <img id="profileImagePreview" src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img id="profileImagePreview" src="{{ asset('image/default-avatar.jpg') }}" alt="Default Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                        <div class="edit-icon">
                            <i class="bi bi-pencil-fill"></i>
                        </div>
                        <input type="file" name="profile_photo" class="form-control position-absolute" style="top: 0; left: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer;" id="fileInput" accept="image/*">
                    </div>
                    
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" id="name">
                </div>

                <button class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Menambahkan event listener untuk input file
    document.getElementById('fileInput').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('profileImagePreview').src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>

<style>
    .profile-image-container {
        position: relative;
        display: inline-block;
    }

    .edit-icon {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0);
        color: white;
        padding: 5px;
        border-radius: 50%;
        cursor: pointer;
        opacity: 1; /* Mengubah opacity menjadi 1 agar selalu terlihat */
        transition:  background-color 0.2s ease; /* Menambahkan transisi background-color */
    }

    .profile-image-container:hover .edit-icon {
        background-color: rgba(0, 0, 0, 0.8);
    }

    #profileImagePreview {
        transition: filter 0.3s ease;
    }

    #profileImagePreview:hover {
        filter: brightness(70%);
    }
</style>
@endsection
