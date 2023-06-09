<div class="col-md-3">
    <ul class="list-group">
        <li class="list-group-item"><strong>Welcome <i><u>{{ auth()->user()->name }}</u></i></strong></li>
        <li class="list-group-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        @if (auth()->user()->is_admin)
        <li class="list-group-item"><a href="{{ url('admin/questions') }}">Questions</a></li>
        <li class="list-group-item"><a href="{{ url('admin/exam/all-results') }}">Results</a></li>
        @else
        <li class="list-group-item"><a href="{{ url('student/exam') }}">Start Exam</a></li>
        <li class="list-group-item"><a href="{{ url('student/exam/result') }}">Result</a></li>
        @endif
        <li class="list-group-item"><a href="{{ url('logout') }}">Logout</a></li>
    </ul>
</div>