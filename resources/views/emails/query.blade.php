<div style="border: 1px solid black; padding: 30px;">
    <h1 style="color: black;">Customer Query</h1><br><br>
    <p>First Name: {{$query->first_name}}</p><br>
    <p>Last Name: {{$query->last_name}}</p><br>
    <p>Email: {{$query->email}}</p><br>
    <p>Phone: {{$query->phone}}</p><br><br>
    <h3>Query</h3><br>
    <p>
        {{$query->query}}
    </p>
</div>