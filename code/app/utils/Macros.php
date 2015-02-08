<?php namespace App\Util; 

\HTML::macro('button', function ($type = 'button', $name, $options = array()){
	if (!isset($options['type']))
		$options['type'] = $type;

	if (array_key_exists('id', $options)) {
		return $options['id'];
	}

	return '<button ' . \HTML::attributes($options) . '>' . $name . '</button>' ;
});

\HTML::macro('activeLink', function($url) {
	return \Request::is($url) ? 'active current' : '';
});

\HTML::macro('activeState', function($urls = array()) {
	if (count($urls) > 0) {
		for($i=0;$i<count($urls);$i++){
			if(\Request::path() == $urls[$i]) {
				echo "active current";
			}
		}
	}
});

\HTML::macro('create_nav', function () {
});

\HTML::macro('load_documents', function () {
	$id        = 1;
	$doc_name  = 'document.xls';
	$extension = 'xls';
	$type      = 'document';
	$image_url = 'images/files/media-%s.png';
	$image     = HTML::image(sprintf($image_url, $extension), null, array('class' => ''));
	$created   = Carbon::now()->toFormattedDateString();
	$element   = '<div class="col-xs-6 col-sm-4 col-md-3 %s">
                    <div class="thmb">
                        <div class="ckbox ckbox-default">
                            <input type="checkbox" id="check%d" value="1"/>
                            <label for="check%d"></label>
                        </div>
                        <div class="btn-group fm-group">
                            <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu fm-menu" role="menu">
                                <li><a href="' . URL::to('#') . '"><i class="fa fa-envelope-o fa-fw"></i>Email</a></li>
                                <li><a href="' . URL::to('#') . '"><i class="fa fa-print fa-fw"></i>Imprimir</a></li>
                                <li><a href="' . URL::to('#') . '"><i class="fa fa-download fa-fw"></i>Descargar</a></li>
                                <li><a href="' . URL::to('#') . '"><i class="fa fa-trash-o fa-fw"></i>Eliminar</a></li>
                            </ul>
                        </div>
                        <!-- btn-group -->
                        <div class="thmb-prev text-center">
                            <span>%s</span>
                        </div>
                        <h5 class="fm-title"><a href="' . URL::to('#') . '">%s</a></h5>
                        <small class="text-muted">Agregado: %s</small>
                    </div>
                    <!-- thmb -->
                </div>';
	$output    = sprintf($element, $type, $id, $id, $image, $doc_name, $created);

	return $output;
});

\HTML::macro('load_tags', function ($metas = array()) {
	if (count($metas) > 0) {
		$tags = '<ul class="tag-list">';
		foreach ($metas as $value) {
			$tags .= sprintf('<li><a href = "' . URL::to('#') . '">%s</a></li>', $value);
		}
		$tags .= '</ul >';
	} else {
		$tags = '<div class="alert alert-danger">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                        No se encontraron etiquetas<strong>!</strong>.
				    </div>';
	}

	return $tags;
});

\HTML::macro('load_searchresult', function ($keyword = null) {
	if (isset($keyword)) {
		return;
	}

	return $keyword;
});
