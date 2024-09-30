<style>.thing-box{
        border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
        border:solid 4px white;
    }
</style>
<div class="m-16">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($things as $thing)
            <div class="thing-box p-4 bg-teal-1000 hover:bg-teal-800 hover:-rotate-1 rounded-lg shadow-xl hover:shadow-2xl border-2 border-white h-auto relative">
                <div class="absolute top-2 right-2 bg-red-600 w-16 h-16 rounded-full flex items-center justify-center">
                    <span class="text-white text-3xl font-bold">{{$thing->months_alive}}</span>
                </div>
                <div class="w-full h-auto max-w-full max-h-full overflow-hidden">
                    <div class="w-full text-white h-auto flex justify-center items-center p-x-8 p-y-2">
                        {!! $thing->picture !!}
                    </div>
                </div>
                <h2 class="text-2xl text-white">{{ $thing->name }}</h2>
                <p class="text-white">{{ $thing->description }}</p>
                <p class="text-white">{{ round($thing->price_per_day*100,1) }} Rp./Tag</p>
            </div>
        @endforeach
    </div>
</div>
<footer class="bg-gray-900 text-white text-right p-4 ">
    <p>&copy; 2024 by <a href="https://problem.li" class="underline">Problemli</a></p>
</footer>
