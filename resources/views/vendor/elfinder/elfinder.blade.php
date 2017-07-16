@extends('layouts.elfinder_master')

@section('after_scripts')

    <!-- elFinder JS (REQUIRED) -->
    <script src="<?= asset($dir.'/js/elfinder.min.js') ?>"></script>

    <?php if($locale){ ?>
    <!-- elFinder translation (OPTIONAL) -->
    <script src="<?= asset($dir."/js/i18n/elfinder.$locale.js") ?>"></script>
    <?php } ?>

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here
                @if($locale){ ?>
                    lang: '<?= $locale ?>', // locale
                @endif
                customData: {
                    _token: '<?= csrf_token() ?>'
                },
                url : '<?= route("elfinder.connector") ?>'  // connector URL
            });
        });
    </script>
@endsection

@section('content')
    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>
@endsection