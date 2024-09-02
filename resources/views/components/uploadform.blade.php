<h2 class="text-2xl font-bold text-white text-center mb-12">Upload your image<span class="text-sm text-gray-400"> (10MB Max)</span></h2>
<div class="flex items-center justify-center mx-28">
    <form id="form" method="POST" action="{{ route('thumbnail.upload') }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="flex items-center space-x-6">
        <div class="shrink-0">
            <img id='preview_img' class="w-36" src="https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExcnVwbG1kaGV1M3JyODhqcTF6MmN6ZnZzbmFmc2NjM3JxeXQ4MWpiNCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/oQaxL4L1IA6uehswWd/giphy.gif" alt="Current profile photo" />
        </div>
            <label class="block">
                <span class="sr-only">Choose thumbnail photo</span>
                <input type="file" name="thumbnail" id="thumbnail" onchange="loadFile(event)" class="block w-full text-sm text-slate-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-violet-50 file:text-black
                hover:file:bg-violet-100
                "/>
            </label>
        </div>
        <div class="mt-6 flex items-center justify-center pt-12">
            <button type="submit"
                class="rounded-md bg-violet-50 px-8 py-2 text-md font-bold text-black shadow-sm hover:bg-tomatohover focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Upload</button>
        </div>
    </form>
</div>


  <script>
          var loadFile = function(event) {

              var input = event.target;
              var file = input.files[0];
              var type = file.type;

             var output = document.getElementById('preview_img');


              output.src = URL.createObjectURL(event.target.files[0]);
              output.onload = function() {
                  URL.revokeObjectURL(output.src) // free memory
              }
          };
  </script>
