<div class="bg-white py-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <ul role="list" class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        @foreach($thumbnails as $thumb)
        <li>
          <img class="aspect-[3/2] w-full rounded-2xl object-cover" src="{{ Storage::url("thumbnails/" . $thumb->user_id . '/' . $thumb->name) }}" alt="">
          <div class="flex justify-center mt-2 space-x-2">
            <a href="{{ 'thumbnails/' . $thumb->user_id . '/' . $thumb->name }}" download class="px-4 py-1 rounded text-sm"><svg width="30" height="30" viewBox="0 0 5214 4581" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                <g transform="matrix(1,0,0,1,0,-3.25012)">
                    <g transform="matrix(4.16667,0,0,4.16667,0,0)">
                        <path d="M1046.07,635.154L1046.07,894.891L205.11,894.891L205.11,635.154L0,635.154L0,1100L1251.18,1100L1251.18,635.154L1046.07,635.154Z" style="fill-rule:nonzero;"/>
                    </g>
                    <g transform="matrix(4.16667,0,0,4.16667,0,0)">
                        <path d="M1251.18,1100L1251.18,635.154L1206.09,1054.48L43.385,1054.48L0,635.154L0,1100L1251.18,1100Z" style="fill-rule:nonzero;"/>
                    </g>
                    <g transform="matrix(4.16667,0,0,4.16667,0,0)">
                        <path d="M937.245,366.032L762.7,366.032L762.7,0.78L488.484,0.78L488.484,366.032L313.912,366.032L625.567,867.54L937.245,366.032Z" style="fill-rule:nonzero;"/>
                    </g>
                    <g transform="matrix(4.16667,0,0,4.16667,0,0)">
                        <path d="M528.382,383.196L488.484,0.78L488.484,366.032L313.913,366.032L625.567,867.54L364.576,383.196L528.382,383.196Z" style="fill-rule:nonzero;"/>
                    </g>
                    <g transform="matrix(4.16667,0,0,4.16667,0,0)">
                        <path d="M627.951,826.438L602.255,155.152L727.519,13.829L727.519,402.468L875.266,402.468L627.951,826.438Z" style="fill-rule:nonzero;"/>
                    </g>
                    <g transform="matrix(4.16667,0,0,4.16667,0,0)">
                        <path d="M1109.73,961.337L133.319,961.337L33.749,662.631L175.074,662.631L175.074,935.642L1084.04,935.642L1084.04,665.843L1212.52,665.843L1109.73,961.337Z" style="fill-rule:nonzero;"/>
                    </g>
                </g>
            </svg></a>
            <form action="{{ route('thumbnail.removeBackground') }}" id="bgForm" method="POST" enctype="multipart/form-data" class="inline">
                @csrf
                <input type="hidden" name="thumbnail_url" value="{{ Storage::url("thumbnails/" . $thumb->user_id . '/' . $thumb->name) }}">
                <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded text-sm"
                    x-data="{loading:false}"
                    x-on:click="loading=true; document.getElementById('bgForm').submit();"
                    x-html="loading ? 'Processing...' : 'Remove BG'" class="disabled:opacity-50"
                    x-bind:disabled="loading"
    >Remove BG</button>
              </form>
              <form action="{{ route('thumbnail.delete', $thumb) }}" method="POST" class="inline text-sm">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-1 rounded"><svg width="30" height="30" viewBox="0 0 232 232" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                    <g transform="matrix(1,0,0,1,0.000157824,-1.65437)">
                        <g transform="matrix(4.16667,0,0,4.16667,0,0)">
                            <path d="M54.896,43.313L40.101,28.52L54.917,13.703C56.49,12.132 55.076,11.002 53.503,9.431L46.57,2.495C44.997,0.924 43.868,-0.489 42.296,1.082L27.48,15.898L12.733,1.152C11.348,-0.233 10.035,0.995 8.462,2.566L2.301,8.727C0.73,10.298 -0.497,11.614 0.888,12.998L15.634,27.744L0.684,42.694C-0.885,44.266 0.526,45.395 2.098,46.967L9.032,53.901C10.604,55.473 11.733,56.886 13.306,55.315L28.253,40.366L43.047,55.161C44.39,56.5 45.748,55.319 47.318,53.747L53.48,47.587C55.052,46.014 56.236,44.655 54.896,43.313Z" style="fill:rgb(224,0,0);fill-rule:nonzero;"/>
                        </g>
                    </g>
                </svg></button>
            </form>
          {{-- <h3 class="mt-6 text-lg font-semibold leading-8 tracking-tight text-gray-900">{{ $thumb->name }}</h3> --}}
        </li>
        @endforeach
      </ul>
    </div>
  </div>
