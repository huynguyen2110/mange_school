
@extends('layouts.admin')

@section('content')
    <insert-score
        :data="{{json_encode([
            'urlBack' => route('students.index'),
            'urlStore' => $isEdit ? route('students.update-score') : route('students.insert-score'),
            'class_id' => $class_id,
            'student_id' => $student_id,
            'isEdit' => $isEdit,
            'score' => $score,
])}}">
    </insert-score>
@endsection
