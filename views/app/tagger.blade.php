@extends("layouts.template")

@section("page_title", "Interaktiver Editor")@stop

@section("content")
@if($action != 'code')
<link href="{{ url() }}/assets/styles/imgshop.css" rel="stylesheet">
<input type="hidden" id="url" value="{{ url('displaypremiumicon') }}">
    <section id="tagger-ctrl">

        <div class="panel panel-default">
            <div class="panel-toolbar clearfix">
                <h3 class="pull-left padding-xs no-margin">

                    @if(Auth::user()->premium == 0)

                     <img src="icons/tag.png"> <b>Interaktiver</b> Editor (Basic) <a href="http://www.imagemarker.com/help.html" target="blank"><img src="icons/hilfe.png" border="0"></a>


                    @elseif(Auth::user()->premium == 1)

                     <img src="icons/tag.png"> <b>Interaktiver</b> Editor (Premium) <a href="http://www.imagemarker.com/help.html" target="blank"><img src="icons/hilfe.png" border="0"></a>


                    @else(Auth::user()->premium == 2)

                     <img src="icons/tag.png"> <b>Interaktiver</b> Editor (Premium) <a href="http://www.imagemarker.com/help.html" target="blank"><img src="icons/hilfe.png" border="0"></a>


                    @endif


                </h3>

                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ $publicUrl }}" target="_blank">
                        <i class="fa fa-globe"></i>&nbsp; Bildvorschau
                    </a>

                    <a class="btn btn-success" href="{{ URL::current() }}/code">
                        <i class="fa fa-code"></i>&nbsp; Code generieren
                    </a>

                    <!--<a class="btn btn-primary"
                       href="{{ $image->url }}">
                        <i class="fa fa-image"></i>&nbsp; Originalbild
                    </a>-->

                    <form action="{{ URL::current() }}" method="post" style="display: inline-block">
                        <input type="hidden" name="_action" value="delete_image"/>
                        <button class="btn btn-danger" id="btn-generate-code"
                                onclick="return confirm('Bild wirklich löschen?');">
                            <i class="fa fa-times"></i>&nbsp; Bild löschen
                        </button>
                    </form>
                </div>
            </div>

            <div class="panel-body">
                <div id="tag-image-container">
                    @if(Auth::user()->premium == 0)

                      @include("app.partials.tagger-product-modal-pro")

                    @elseif(Auth::user()->premium == 1)

                      @include("app.partials.tagger-product-modal-pro")

                    @else(Auth::user()->premium == 2)

                      @include("app.partials.tagger-product-modal-pro")

                    @endif
                    <div id="tag-image-holder" style="margin: 0; float: left; max-width: 780px;">
                        <div id="tag-imagger" style="visibility: hidden;"><img src="{{ $image->url }}" id="tag-image" /></div>
                        <style>
                            div#loading_container {
                                width: 780px;
                                background: #FFF;
                                margin: 0 auto;
                                text-align: center;
                                border-radius: 5px;
                                z-index: 99999;
                            }
                        </style>
                        <div id="loading_container"><img width="420" src="{{ url('assets/images/loading.jpg') }}"></div>
                    </div>
                </div>
            </div>

        </div>


        @include("app.partials.handlebar-templates")
        @include("app.partials.public-url-modal")

    </section>
@endif
 <input id="iconselect" type="hidden" value="0">
@if($action == 'code')
<style>
.modal-backdrop.in { display: none; }
.tag-image-marker { display: none; }
</style>
    <section id="tagger-ctrl">

        <div class="panel panel-default">
            <div class="panel-toolbar clearfix">
                <h3 class="pull-left padding-xs no-margin">
                    <img src="../icons/tag.png"> HTML-Code für Websites <a href="http://www.imagemarker.com/help.html" target="blank"><img src="../icons/hilfe.png" border="0"></a>
                </h3>

                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ $publicUrl }}" target="_blank">
                        <i class="fa fa-globe"></i>&nbsp; Bildvorschau
                    </a>



                    <!--<a class="btn btn-primary"
                       href="{{ $image->url }}">
                        <i class="fa fa-image"></i>&nbsp; Originalbild
                    </a>-->

                    <form action="{{ URL::current() }}" method="post" style="display: inline-block">
                        <input type="hidden" name="_action" value="delete_image"/>
                        <button class="btn btn-danger" id="btn-generate-code"
                                onclick="return confirm('Bild wirklich löschen?');">
                            <i class="fa fa-times"></i>&nbsp; Möchten Sie das Bild wirklich löschen?
                        </button>
                    </form>
                </div>
            </div>

            <div class="panel-body">

                <div id="tag-image-container">
                        @include("app.partials.tagger-code-modal")

                    <div id="tag-image-holder" style="margin: 0; float: left; max-width: 780px; display: none;">
                        <img src="{{ $image->url }}" id="tag-image"/>

                    </div>
                </div>

        </div>
        @include("app.partials.handlebar-templates")

    </section>
@endif
@overwrite

@section("styles:end")
<style>
@foreach($tags_icons as $icon)
.tag-image-marker.i{{ $icon->id }} {
  background: url('{{ $icon->image }}');
  opacity: 1.0;
  width: 30px;
  height: 30px;
  background-size: 30px;
  border-radius: 0%!important;
}
@endforeach
</style>
@stop

@section("scripts_lib")
    <script src="{{ url('assets/scripts/handlebars.js') }}"></script>
@overwrite

@section("scripts_app_before")
    <script type="text/javascript">
        App.set('image_public_url', '{{ $publicUrl }}');
        App.set('tagger_image', {{ json_encode($image) }});
        App.set('tagger_image_tags', {{ $image->tags->toJSON() }});
        App.set('tags_icons', {{ json_encode($tags_icons) }});
        App.set('image', {{ json_encode($image) }});

    @foreach($tags_icons as $icon)
        $('#color-{{ $icon->id }}').click(function() {
            $("#iconselect").val(1);
          $("#color-div .active").removeClass('active');
          $(this).toggleClass('active');
          document.getElementById('color').value = 'i'+{{ $icon->id }};
          document.getElementById('color').checked = true;
        });
    @endforeach
    </script>
@stop
