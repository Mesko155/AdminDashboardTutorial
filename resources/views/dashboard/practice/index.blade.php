<x-layout>
    @include('partials._header')

    <div>
        <form action="\dashboard\practices\create" method="GET">
        <button>Create new practice</button>
        </form>
    </div>

    <div>
        @if($practices)
        <ul>
        @foreach($practices as $practice)
            <li>
            <x-practice-card :practice="$practice"/>

            <form action="/dashboard/practices/{{$practice->id}}/edit">
                <button>Edit</button>
            </form>

            <form action="/dashboard/practices/{{$practice->id}}" method="POST">
                <button>Delete</button>
                @csrf
                @method('DELETE')
            </form>
            </li>       
        @endforeach
        </ul>

        @else
            {{'No practices registered!'}}
        @endif
    </div>
    <div>
        {{$practices->links()}}
    </div>
</x-layout>