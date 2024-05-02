<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <button type="button" class="btn btn-primary my-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Загрузить файл
        </button>
        @foreach($files as $file)
            <p><a href="/downloadFile/{{$file->id}}">{{$file->filename}} </a> - {{$file->file_size}}Kb</p>
        @endforeach
    </div>

    <div class="modal" tabindex="-1" id="exampleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Заголовок модального окна</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div id="fileDrop" class="col-sm-12 bg-info" style="height: 200px;">

                    </div>
                    <form action="/loadfile" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input name="userfile[]" type="file" class="form-control" multiple>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="form-control btn btn-primary" value="Загрузить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const fileDrop = document.getElementById('fileDrop');
        let files = [];
        function FileSelectHandler(e){
            e.preventDefault()
            e.stopPropagation()
            console.log('drop!!!');
            let f = Array.from(e.target.files || e.dataTransfer.files);
            f.forEach(item=>files.push(item));
            // парсим все объекты типа File
            // for (let i = 0, f; f = files[i]; i++){
            //     ParseFile(f, i);
            // }
        }
        fileDrop.addEventListener("drop", FileSelectHandler, false);

        fileDrop.addEventListener('dragend', function (e){
            e.preventDefault()
            e.stopPropagation()
            console.log('dragend');
        }, false)
        fileDrop.addEventListener('dragenter', function(e){
            e.preventDefault()
            e.stopPropagation()
            console.log('dragenter');
        }, false);
        fileDrop.addEventListener("dragover", (e)=>{
            e.preventDefault()
            e.stopPropagation()
            console.log('dragover');
        }, false);
        fileDrop.addEventListener("dragleave", (e)=>{
            e.preventDefault()
            e.stopPropagation()
            console.log('dragleave');
        }, false);
    </script>
</body>
</html>
