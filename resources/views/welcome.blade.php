<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="favicon.svg">

        <title>Dauerhaft</title>

        <!-- Fonts -->
        <script src="{{ basset('https://cdn.tailwindcss.com')}}"></script>
        <script defer data-domain="dauerhaft.ch" src="{{basset('https://plausible.problem.li/js/script.js')}}"></script>
            <style>
                /* latin */
                @font-face {
                    font-family: 'Alfa Slab One';
                    font-style: normal;
                    font-weight: 400;
                    src: url(/fonts/alfa-slab-one-latin-400-normal.woff2) format('woff2'), url(/fonts/alfa-slab-one-latin-400-normal.woff) format('woff');
                    unicode-range: U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;
                }

                /* latin-ext */
                @font-face {
                    font-family: 'Alfa Slab One';
                    font-style: normal;
                    font-weight: 400;
                    src: url(/fonts/alfa-slab-one-latin-ext-400-normal.woff2) format('woff2'), url(/fonts/alfa-slab-one-latin-ext-400-normal.woff) format('woff');
                    unicode-range: U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF;
                }


                body{
                    font-family: 'Alfa Slab One', serif
                }
            </style>

    </head>
    <body class="antialiased bg-teal-900 text-white">
    <p class="text-6xl font-alfa">dauerhaft.ch</p>
    <div class="block py-12 min-h-[65vh] max-w-[65vh] m-auto group">
        <img src="{{asset('img/happy.svg')}}" alt="hero" class="h-[55vh] m-auto group-hover:hidden">
        <img src="{{asset('img/sad.svg')}}" alt="sad" class="h-[55vh] m-auto hidden group-hover:block">
    </div>
    @include('thing-grid')
    </body>
</html>
