<x-layout>
    @include('partials._header')


    <div>
        <h2>{{$field->tag}}</h2>

        <p>is practiced by:</p>
        <ul>
            @foreach($field->practices as $practice)
                <li>
                    <a href="/dashboard/practices/{{$practice->id}}">{{$practice->name}}</a>
                </li>

            @endforeach
        </ul>
    </div>


    <form action="/dashboard/fields/{{$field->id}}/edit">
        <button>Edit name</button>
    </form>

    <form action="/dashboard/fields/{{$field->id}}" method="POST">
        <button>Delete</button>
        @csrf
        @method('DELETE')
    </form>

</x-layout>