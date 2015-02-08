{{-- AngularJS --}}
{{ HTML::script('js/angularJS/angular.min.js') }}
{{ HTML::script('js/angularJS/i18n/angular-locale_es-cl.js') }}
{{-- Main app --}}
{{ HTML::script('js/app.js') }}
{{-- Factory root --}}
<script>
    reportesDespacho.factory('rootFactory', function () {
        var servicio = {
            root: "{{ Request::root() }}"
        };
        return servicio;
    });
</script>
{{-- Components --}}
{{ HTML::script('js/factories.js') }}
{{ HTML::script('js/directives.js') }}
{{ HTML::script('js/controllers.js') }}
