<x-layout>
    @include('partials._header')

    <div>
        <form action="/dashboard/employees/create" method="GET">
        <button>Add new employee</button>
        </form>
    </div>

    <div>
        @if($employees)
        {{-- {{dd($employees)}} --}}
        <ul>
        @foreach($employees as $employee)
            <li>
            <a href="/dashboard/employees/{{$employee->id}}">
                <p>{{$employee->firstname . ' ' . $employee->lastname}}</p>
            </a>

            <p>{{' works at '}}</p>

            <a href="/dashboard/practices/{{$employee->practice->id}}">
                <p>{{$employee->practice->name}}</p>
            </a>
            

            <form action="/dashboard/employees/{{$employee->id}}/edit">
                <button>Edit</button>
            </form>

            <form action="/dashboard/employees/{{$employee->id}}" method="POST">
                <button>Delete</button>
                @csrf
                @method('DELETE')
            </form>
            </li>          
        @endforeach
        </ul>

        @else
            {{'No employees registered!'}}
        @endif
    </div>
    <div>
        {{$employees->links()}}
    </div>

</x-layout>