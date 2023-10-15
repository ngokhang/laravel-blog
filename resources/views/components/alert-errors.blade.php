@if ($errors->any())
    @php
        $html = "<ul style='list-style: none;'>";
        foreach ($errors->all() as $error) {
            $html .= "<li>$error</li>";
        }
        $html .= '</ul>';

        Alert::html('Error during the creation!', $html, 'error');
    @endphp
@endif
