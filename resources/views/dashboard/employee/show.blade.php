<x-layout>
    @include('partials._header')

    <div>
    <ul>
    <li>{{'Name: ' . $employee->firstname}}</li>
    <li>{{'Surname: ' . $employee->lastname}}</li>
    <li>{{'Email: '}}<a href="mailto: {{$employee->email}}">{{$employee->email}}</a></li>
    <li>{{'Phone: ' . $employee->phone}}</li>
    <li>
        {{'Works at:'}}
        <a href="/dashboard/practices/{{$employee->practice->id}}">
            <p>{{$employee->practice->name}}</p>
        </a>
    </li>

    <form action="/dashboard/employees/{{$employee->id}}/edit">
        <button>Edit</button>
    </form>

    <form action="/dashboard/employees/{{$employee->id}}" method="POST">
        <button>Delete</button>
        @csrf
        @method('DELETE')
    </form>
    
    </ul>
    </div>
</x-layout>