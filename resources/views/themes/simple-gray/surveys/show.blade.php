@extends('themes.simple-gray.layout.site', [
    'title' => 'Анкета: ' . $survey->title,
    'seoDescription' => 'Анкета: ' . $survey->title . ' - ' . ($survey->description ?? 'Будь ласка, заповніть цю анкету для покращення наших послуг.'),
])

@section('content')

@endsection
