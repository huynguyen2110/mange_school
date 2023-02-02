<ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ request()->is("teachers/*") ? "c-active" : "" }}" href="{{route('teachers.index')}}">
            <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt"></i>
            Giảng viên
        </a>
    </li>

    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ request()->is("students/*") ? "c-active" : "" }}" href="{{route('students.index')}}">
            <i class="c-sidebar-nav-icon fas fa-fw fa-user-alt"></i>
            Sinh viên
        </a>
    </li>

    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ request()->is("majors/*") ? "c-active" : "" }}" href="{{route('majors.index')}}">
            <i class="c-sidebar-nav-icon fas fa-fw fa-address-card"></i>
            Ngành
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ request()->is("courses/*") ? "c-active" : "" }}" href="{{route('courses.index')}}">
            <i class="c-sidebar-nav-icon fas fa-wrench"></i>
            Khóa
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ request()->is("classes/*") ? "c-active" : "" }}" href="{{route('classes.index')}}">
            <i class="c-sidebar-nav-icon fas fa-fw fa-tasks"></i>
            Lớp học
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ request()->is("subjects/*") ? "c-active" : "" }}" href="{{route('subjects.index')}}">
            <i class="c-sidebar-nav-icon fas fa-fw fa-tasks"></i>
            Môn học
        </a>
    </li>
    <li class="c-sidebar-nav-divider"></li>
    <li class="c-sidebar-nav-item mt-auto"></li>
    <li class="c-sidebar-nav-item"><a href="{{route('logout')}}" class="c-sidebar-nav-link"
                                      >
            <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt"></i>
            Logout</a>
    </li>
</ul>
