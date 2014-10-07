<meta charset="UTF-8">
<title>{{ $page_title .' - '. $title }}</title>

{{ HTML::style('assets/css/bootstrap.min.css') }}
{{ HTML::style('assets/css/style.css') }}
<link rel="stylesheet/less" type="text/css" href="{{ asset('assets/css/style.less?v=3.11') }}" />
{{ HTML::script('assets/js/jquery-2.1.1.min.js') }}
{{ HTML::script('assets/js/less.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
{{ HTML::script('assets/js/jquery.tablesorter.min.js') }}
{{ HTML::script('assets/js/init.js') }}
{{ HTML::script('assets/js/functions.js') }}

<script>
var toggleCheckboxAction = "{{ action('ActionController@postToggleValue') }}";
$(".table").tablesorter();
</script>