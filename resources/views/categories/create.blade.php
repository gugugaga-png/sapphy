


<form action="{{ route('categories.store') }}" method="POST">
<div class="modal-body">
    
        @csrf
    
       <div class="mb-3">
        <label for="name" class="form-label">Nama Kategori:</label><br>
        <input type="text" name="name" id="name" class="form-control"><br><br>
       </div>
    
        
    

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-dark">Simpan</button>

</div>
</form>