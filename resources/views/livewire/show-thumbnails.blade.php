<div class="bg-white py-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <ul role="list" class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        @foreach($thumbnails as $thumb)
        <li>
          <img class="aspect-[3/2] w-full rounded-2xl object-cover" src="{{ Storage::url("thumbnails/" . $thumb->user_id . '/' . $thumb->name) }}" alt="">
          <div class="flex justify-between mt-2">
            <a href="{{ 'thumbnails/' . $thumb->user_id . '/' . $thumb->name }}" download class="bg-blue-500 text-white px-4 py-2 rounded">Download</a>
            <button class="bg-gray-700 text-white px-4 py-2 rounded">Remove BG</button>
          </div>
          {{-- <h3 class="mt-6 text-lg font-semibold leading-8 tracking-tight text-gray-900">{{ $thumb->name }}</h3> --}}
        </li>
        @endforeach
      </ul>
    </div>
  </div>
