<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <meta name="author" content="Links S.A">
        <meta name="keyword" content="CRM ADMIN">
        <!-- styles -->
        <link href="{{ asset('constructor-mail/css/colpick.css') }}" rel="stylesheet"  type="text/css"/>

        <link rel="stylesheet" href="{{ asset('constructor-mail/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('constructor-mail/css/font-awesome.min.css') }}">
        <link href="{{ asset('constructor-mail/css/themes/default.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('constructor-mail/css/themify-icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('constructor-mail/css/template.editor.css') }}" rel="stylesheet"/>
        <link href="{{ asset('constructor-mail/css/responsive-table.css') }}" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ asset('constructor-mail/css/dropzone.css') }}">
        <link rel="stylesheet" href="{{ asset('constructor-mail/css/app.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css')}}">
       <!--<link href="../vendor/sweetalert/lib/sweet-alert.css" rel="stylesheet">-->
        <script type="text/javascript"> var path = '';</script>
        <script type="text/javascript" src="http://feather.aviary.com/js/feather.js"></script>
        
        <script src="{{ asset('constructor-mail/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('constructor-mail/js/jquery-ui.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="{{ asset('constructor-mail/js/dropzone.js') }}"></script>
        <script type="text/javascript" src="{{ asset('constructor-mail/js/jquery.ui.touch-punch.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('constructor-mail/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('constructor-mail/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('constructor-mail/js/plugin.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('constructor-mail/js/colpick.js') }}"></script>

        <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('constructor-mail/js/template.editor.js') }}"></script>
        <script src="{{ asset('js/plantillas.js') }}"></script>
     <!--   <script type="text/javascript" src="../vendor/sweetalert/lib/sweet-alert.js"></script>-->
     <!--   <script type="text/javascript" src="../../administrador/js/validaciones.js"></script>-->
    </head>
    <body class="edit">
        <div class="navbar navbar-inverse navbar-fixed-top navbar-layoutit">
            <div class="navbar-header">
                <button data-target="navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                </button>
            </div>
          
            <div class="collapse navbar-collapse">
                <ul class="nav" id="menu-layoutit">
                    <li>
                        <span id="messagefromphp"></span>
                        <span id="messagefromphp2"></span>
                        
                        <div class="btn-group">
                            <a class="btn" style="background-color:#3f6ad8; color:#fff"  onClick="Guardar();" ><i class="ti-save"></i> Guardar</a>
                        </div>
                    </li>
                </ul>
            </div><!--/.navbar-collapse -->
        </div><!--/.navbar-fixed-top -->
        <div class="row"style="padding: 10px;padding-right: 25px;">
            <div class="sidebar-nav" style="overflow:scroll;">
                <!-- Nav tabs -->
                <div id="elements">
                    <ul class="nav nav-list accordion-group">
                        <li class="rows" id="estRows">
                            <!-------- Titulo ----------->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a>  </span>
                                <div class="preview">
                                    <div class="icon title-block"></div>
                                    <label>Titulo</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table width="640" class="main" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#FFFFFF;" data-type="title">
                                            <tbody>
                                                <tr>
                                                    <td align="left" class="title" style="padding:5px 50px 5px 50px">
                                                        <h1 style="font-family:Arial"> Ingrese algun titulo aquí! </h1>
                                                       <h4 style="font-family:Arial">y su subtitulo aqui</h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!------- Divisor ------->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span> 

                                <div class="preview">
                                    <div class="icon divider-block"></div>
                                    <label>Divisor</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table class="main" width="640" style="border:0px; background-color: #FFFFFF" cellspacing="0" cellpadding="0" border="0" align="center" data-type='line'>
                                            <tr>
                                                <td class="divider-simple" style="padding: 15px 50px 0px 50px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-top: 1px solid #DADFE1;">
                                                        <tr>
                                                            <td width="100%" height="15px"></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!------- Texto ----------->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon text-block"></div>
                                    <label>Texto</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table width="640" class="main" cellspacing="0" cellpadding="0" border="0" style="background-color:#FFFFFF" align="center" data-type='text-block'>
                                            <tbody>
                                                <tr>
                                                    <td class="block-text" data-clonable="true" align="left" style="padding:10px 50px 10px 50px;font-family:Arial;font-size:13px;color:#000000;line-height:22px">
                                                        <div style="margin:0px 0px 10px 0px;line-height:22px">Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Imagen -->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon image-block"></div>
                                    <label>Imagen</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table width="640" class="main" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#FFFFFF;" data-type="image">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="padding:15px 50px 15px 50px;" class="image">
                                                            <a class="link" href="#" data-link=""><img class=""  border="0" width="100%"  align="one_image" style="display:block;max-width:640px" alt="" src="https://assets.prestashop2.com/sites/default/files/styles/blog_750x320/public/wysiwyg/que_es_el_mailing.png?itok=wSbvrVov" tabindex="0"></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Botones -->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon button-block"></div>
                                    <label>Botones</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">

                                        <table width="640" class="main" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF"  align="center"  style="background-color:#FFFFFF;" data-type="button">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 15px 50px 15px 50px;" class="buttons-full-width">
                                                        <table width="" cellspacing="0" cellpadding="0" border="0" align="center" class="button">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="margin: 10px 10px 10px 10px;" class="button">
                                                                        <a style="background-color: #3498DB;color: #FFFFFF;font-family: Arial;font-size: 15px;line-height:21px;display: inline-block;border-radius: 6px;text-align: center;text-decoration: none;font-weight: bold;display: block;margin: 0px 0px; padding: 12px 20px;" class="button-1" href="#" data-default="1">Click Aquí</a>
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--Imagen & textos -->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon image-text-block"></div>
                                    <label>Imagen/Texto</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table class="main" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center" style="background-color:#FFFFFF;" data-type="imgtxt">
                                            <tbody>
                                                <tr>
                                                    <td class="image-text" align="left" style="padding: 15px 50px 10px 50px; font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;">
                                                        <table class="image-in-table" width="190" align="left" style="padding:5px">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="gap" width="30"></td>
                                                                    <td width="160">
                                                                    <a class="link"> <img  border="0"  align="left" width="100%" src="http://revistacomunicaccion.com/images/Actualidad/MAILING.jpg" style="display: block;margin: 0px;max-width: 540px;padding:10px;"></a>                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                            </tbody>
                                                        </table>
                                                        <p style="margin: 0px 0px 10px 0px; line-height: 22px;">
                                                            Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- TEXTO E IMAGEN EN TEXTO DE COLUMNA EN EL LADO DERECHO-->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon image-text-col-2"></div>
                                    <label>Imagen/Texto</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table class="main" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center" style="background-color:#FFFFFF;" data-type="imgtxtcol">
                                            <tbody>
                                                <tr>
                                                    <td class="image-text" align="left" style="padding: 15px 50px 10px 50px; font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;">
                                                        <table class="image-in-table" width="190" align="left">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="gap" width="30"></td>
                                                                    <td width="160">
                                                                        <a class="link"><img border="0"  align="left" src="http://revistacomunicaccion.com/images/Actualidad/MAILING.jpg" style="display: block;margin: 0px;max-width: 340px"></a>                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table width="190">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-block"  >
                                                                        <p style="margin-left:10px; line-height: 22px;">
                                                                            Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- TEXTO E IMAGEN EN TEXTO DE COLUMNA EN EL LADO IZQUIERDO -->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon image-text-col-1"></div>
                                    <label>Imagen/Texto</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table class="main" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center" style="background-color:#FFFFFF;" data-type="imgtxtcol">
                                            <tbody>
                                                <tr>
                                                    <td class="image-text" align="left" style="padding: 15px 50px 10px 50px; font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;">
                                                        <table width="190" align="left">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-block"  >
                                                                        <p style="line-height: 22px;">
                                                                            Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="image-in-table" width="190" align="right">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="gap" width="30"></td>
                                                                    <td width="160">
 <a class="link"><img  border="0"  align="left" src="http://revistacomunicaccion.com/images/Actualidad/MAILING.jpg"  style="display: block;margin: 0px;max-width: 340px"></a>                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Imagenes + Texto 2 columnas -->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon image-text-incol-2"></div>
                                    <label>Imagen/Texto</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table class="main" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center" style="background-color:#FFFFFF;" data-type="imgtxtincol">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table class="main" align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="640">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="image-caption" style="padding: 0px 50px 0px 50px;">
                                                                        <table class="image-caption-column" align="left" border="0" cellpadding="0" cellspacing="0" width="255">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content image" style="font-family: Arial; font-size: 13px; color: #000000;">
                  <a class="link" ><img src="https://webescuela.com/wp-content/uploads/2018/05/que-es-mailing.png" alt="" style="display: block;" height="154" align="2" border="0" width="255"></a>                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content text" style="font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;" align="left">
                                                                                        <p style="margin: 0px 0px 10px 0px; line-height: 22px;"> Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos. </P>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-bottom-gap" height="5" width="100%"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table class="image-caption-column" align="right" border="0" cellpadding="0" cellspacing="0" width="255">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="image-caption-top-gap" height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content image" style="font-family: Arial; font-size: 13px; color: #000000;">
  <a class="link"><img src="https://webescuela.com/wp-content/uploads/2018/05/que-es-mailing.png" alt="" style="display: block;" height="154" align="2" border="0" width="255"></a>                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content text" style="font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;" align="left">
                                                                                        <p style="margin: 0px 0px 10px 0px; line-height: 22px;"> Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos. </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="5" width="100%"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Imagenes + Texto 3 columnas -->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon image-text-incol-3"></div>
                                    <label>Imagen/Texto</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table class="main" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center" style="background-color:#FFFFFF;" data-type="imgtxtincol">
                                            <tbody>
                                                <tr>
                                                    <td class="image-caption" style="padding: 0px 50px 0px 50px;">
                                                        <table class="image-caption-container" align="left" border="0" cellpadding="0" cellspacing="0" width="350">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <table class="image-caption-column" align="left" border="0" cellpadding="0" cellspacing="0" width="160">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content image" style="font-family: Arial; font-size: 13px; color: #000000;">
                                                                                                <a class="link"><img src="http://revistacomunicaccion.com/images/Actualidad/MAILING.jpg" alt="" style="display: block;" height="154" align="2" border="0" width="160"></a>
                                                                                     </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content text" style="font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;" align="left">
                                                                                          <p style="margin: 0px 0px 10px 0px; line-height: 22px;">  Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-bottom-gap" height="5" width="100%"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table class="image-caption-column" align="right" border="0" cellpadding="0" cellspacing="0" width="160">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="image-caption-top-gap" height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content image" style="font-family: Arial; font-size: 13px; color: #000000;">
                                                                                             <a class="link"> <img src="http://revistacomunicaccion.com/images/Actualidad/MAILING.jpg" alt="" style="display: block;" height="154" align="2" border="0" width="160"></a>
                                                                                     </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="15" width="100%"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-content text" style="font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;" align="left">
                                                                                        <p style="margin: 0px 0px 10px 0px; line-height: 22px;">Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="image-caption-bottom-gap" height="5" width="100%"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="image-caption-column" align="right" border="0" cellpadding="0" cellspacing="0" width="160">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="image-caption-top-gap" height="15" width="100%"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="image-caption-content image" style="font-family: Arial; font-size: 13px; color: #000000;">
                                                                        <a class="link"> <img src="http://revistacomunicaccion.com/images/Actualidad/MAILING.jpg" alt="" style="display: block;" height="154" align="2" border="0" width="160"></a>
                                                                      </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="15" width="100%"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="image-caption-content text" style="font-family: Arial; font-size: 13px; color: #000000; line-height: 22px;" align="left">
                                                                        <p style="margin: 0px 0px 10px 0px; line-height: 22px;">Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.Este es un bloque de texto! Haga clic en este texto para editarlo. Puede agregar contenido fácilmente arrastrando los bloques de contenido desde la barra lateral derecha. Arrastra este y otros bloques para reordenarlos.</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="5" width="100%"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- SOCIAL LINKS -->
                            <div class="lyrow dragitem">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                <span class="configuration" style="margin-top: 8px;"> <a href="#" class="btn btn-success btn-xs clone" style="padding:6px;"><i class="ti-layers-alt"></i> </a></span>
                                <div class="preview">
                                    <div class="icon social-block"></div>
                                    <label>Social Links</label>
                                </div>
                                <div class="view">
                                    <div class="row clearfix">
                                        <table class="main" align="center" width="640" cellspacing="0" cellpadding="0" border="0" style="background-color: #FFFFFF" data-type="social-links">
                                            <tbody>
                                                <tr>
                                                    <td class="social" align="center" style="padding: 15px 50px 15px 50px;">
                                                        <a href="#" style="border: none;" class="facebook">
                                                            <img border="0" src="{{$url_sitio}}/constructor-mail/img/builder/facebook.png" />

                                                        </a>
                                                        <a href="#" style="border: none;" class="twitter">

                                                            <img border="0" src="{{$url_sitio}}/constructor-mail/img/builder/twitter.png"/>


                                                        </a>
                                                        <a href="#" style="border: none;" class="linkedin">

                                                            <img  border="0" src="{{$url_sitio}}/constructor-mail/img/builder/linkedin.png"/>


                                                        </a>
                                                        <a href="#" style="border: none;" class="youtube">

                                                            <img border=0 src="{{$url_sitio}}/constructor-mail/img/builder/youtube.png"/>


                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <br>
                </div>
                <div class="hide" id="settings">
                    <form class="form-inline" id="common-settings">
                        <h4 class="text text-info">Margen Interno</h4>
                            <center>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td><input type="text" class="form-control" placeholder="top" value="15px" id="ptop" name="ptop" style="width: 60px; margin-right: 5px"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control" placeholder="left" value="15px" id="pleft" name="mtop" style="width: 60px; margin-right: 5px"></td>
                                            <td></td>
                                            <td><input type="text" class="form-control" placeholder="right" value="15px" id="pright" name="mbottom" style="width: 60px; margin-right: 5px"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><input type="text" class="form-control" placeholder="bottom" value="15px" id="pbottom" name="pbottom" style="width: 60px; margin-right: 5px"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </center>

                    </form>
                    <h4  class="text text-info">Estilos</h4>
                    <form id="background"  class="form-inline">
                        <div class="form-group">
                            <label for="bgcolor">Color de Fondo</label>
                            <div class="color-circle" id="bgcolor"></div>
                            <script type="text/javascript">
                                $('#bgcolor').colpick({
                                    layout: 'hex',
                                    onBeforeShow: function () {
                                        $(this).colpickSetColor($('#bgcolor').css('backgroundColor').replace('#', ''));
                                    },
                                    onChange: function (hsb, hex, rgb, el, bySetColor) {

                                        if (!bySetColor)
                                            $(el).css('background-color', '#' + hex);
                                    },
                                    onSubmit: function (hsb, hex, rgb, el) {
                                        $(el).css('background-color', '#' + hex);

                                        $('#' + $('#path').val()).css('background-color', '#' + hex);
                                        $(el).colpickHide();
                                    }

                                }).keyup(function () {
                                    $(this).colpickSetColor(this.value);
                                });
                            </script>
                        </div>
                    </form>
                    <form class="form-inline" id="font-settings" style="margin-top:5px">
                        <div class="form-group">
                            <label for="fontstyle">Estilo de Letras</label>
                            <div id="fontstyle" class="color-circle"><i class="fa fa-font"></i></div>
                        </div>
                    </form>
                    <div class="hide" id='font-style'>
                        <div id="mainfontproperties" >
                            <div class="input-group" style="margin-bottom: 5px">
                                <span class="input-group-addon" style="min-width: 60px;">Color</span>
                                <input type="text" class="form-control picker" id="colortext" >
                                <span class="input-group-addon"></span>
                                <script type="text/javascript">
                                    $('#colortext').colpick({
                                        layout: 'hex',
                                        // colorScheme: 'dark',
                                        onChange: function (hsb, hex, rgb, el, bySetColor) {
                                            if (!bySetColor)
                                                $(el).val('#' + hex);
                                        },
                                        onSubmit: function (hsb, hex, rgb, el) {
                                            $(el).next('.input-group-addon').css('background-color', '#' + hex);
                                            $(el).colpickHide();
                                        }

                                    }).keyup(function () {
                                        $(this).colpickSetColor(this.value);
                                    });
                                </script>
                            </div>
                            <div class="input-group" style="margin-bottom: 5px">
                                <span class="input-group-addon" style="min-width: 60px;">Fuente</span>
                                <input type="text" class="form-control " id="fonttext" readonly>
                            </div>
                            <div class="input-group" style="margin-bottom: 5px">
                                <span class="input-group-addon" style="min-width: 60px;">Tam.</span>
                                <input type="text" class="form-control " id="sizetext" style="width: 100px">
                                &nbsp;
                                <a class="btn btn-default plus" href="#">+</a>
                                <a class="btn btn-default minus" href="#">-</a>
                            </div>

                            <hr/>
                            <div class="text text-right">
                                <a class="btn btn-info" id="confirm-font-properties">OK</a>
                            </div>
                        </div>

                        <div id="fontselector" class="hide" style="min-width: 200px">
                            <ul class="list-group" style="overflow: auto ;display: block;max-height: 200px" >
                                <li class="list-group-item" style="font-family: arial">Arial</li>
                                <li class="list-group-item" style="font-family: verdana">Verdana</li>
                                <li class="list-group-item" style="font-family: helvetica">Helvetica</li>
                                <li class="list-group-item" style="font-family: times">Times</li>
                                <li class="list-group-item" style="font-family: georgia">Georgia</li>
                                <li class="list-group-item" style="font-family: tahoma">Tahoma</li>
                                <li class="list-group-item" style="font-family: pt sans">PT Sans</li>
                                <li class="list-group-item" style="font-family: Source Sans Pro">Source Sans Pro</li>
                                <li class="list-group-item" style="font-family: PT Serif">PT Serif</li>
                                <li class="list-group-item" style="font-family: Open Sans">Open Sans</li>
                                <li class="list-group-item" style="font-family: Josefin Slab">Josefin Slab</li>
                                <li class="list-group-item" style="font-family: Lato">Lato</li>
                                <li class="list-group-item" style="font-family: Arvo">Arvo</li>
                                <li class="list-group-item" style="font-family: Vollkorn">Vollkorn</li>
                                <li class="list-group-item" style="font-family: Abril Fatface">Abril Fatface</li>
                                <li class="list-group-item" style="font-family: Playfair Display">Playfair Display</li>
                                <li class="list-group-item" style="font-family: Yeseva One">Yeseva One</li>
                                <li class="list-group-item" style="font-family: Poiret One">Poiret One</li>
                                <li class="list-group-item" style="font-family: Comfortaa">Comfortaa</li>
                                <li class="list-group-item" style="font-family: Marck Script">Marck Script</li>
                                <li class="list-group-item" style="font-family: Pacifico">Pacifico</li>
                            </ul>
                        </div>
                    </div>
                    <div id="imageproperties" style="margin-top:5px">
                        <div class="form-group">
                             <div class="row">
                                <div class="col-xs-10">
                                    <input type="text" id="image-link-url" class="form-control" data-id="none"/>
                                </div>                                 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-8">
                                    <input type="text" id="image-url" class="form-control" data-id="none"/>
                                </div>
                                <div class="col-xs-4">
                                    <a class="btn btn-default" onClick="javascript:subirimagen('<?php echo "codigo"; ?>');">Buscar</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-2">
                                    Ancho:
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" id="image-w" class="form-control" name="director" />
                                </div>

                                <div class="col-xs-1">
                                    Alto:
                                </div>

                                <div class="col-xs-3">
                                    <input type="text" id="image-h"class="form-control" name="writer" />
                                </div>

                                <div class="col-xs-4" style="margin-top: 5px; margin-bottom: -20px;">
                                    <a class="btn btn-warning" href="#" id="change-image"><i class="fa fa-edit"></i>&nbsp;Aplicar Cambios</a>
                                </div>

                            </div>
                        </div>


                    </div>
                    <form id="editor" style="margin-top:5px">
                        <div class="panel panel-body panel-default html5editor" id="html5editor"></div>
                    </form>
                    <form id="editorlite" style="margin-top:5px">
                        <input type="text" style="width:100%" class="panel panel-body panel-default html5editorlite" id="html5editorlite">
                        Alinear: <select id="allineamento">
                            <option value="">Seleccione una orientación</option>
                            <option value="left">Izquierda</option>
                            <option value="right">Derecha</option>
                            <option value="center">Centro</option>
                        </select>
                    </form>
                    <div id="social-links">
                        <ul class="list-group" id="social-list">
                            <li>
                                <div class="input-group">
                                    <span class="input-group-addon" ><i class="fa fa-2x fa-facebook-official"></i></span>
                                    <input type="text" class="form-control social-input" name="facebook" style="height:48px"/>
                                    <span class="input-group-addon" ><input  type="checkbox" checked="checked" name="facebook" class="social-check"/></span>
                                </div>
                            </li>
                            <li>
                                <div class="input-group">
                                    <span class="input-group-addon" ><i class="fa fa-2x fa-twitter"></i></span>
                                    <input type="text" class=" form-control social-input" name="twitter" style="height:48px"/>
                                    <span class="input-group-addon" ><input type="checkbox" checked="checked" name="twitter" class="social-check"/></span>
                                </div>
                            </li>
                            <li>
                                <div class="input-group">
                                    <span class="input-group-addon" ><i class="fa fa-2x fa-linkedin"></i></span>
                                    <input type="text" class=" form-control social-input" name="linkedin" style="height:48px"/>
                                    <span class="input-group-addon" ><input type="checkbox" checked="checked" name="linkedin" class="social-check"/></span>
                                </div>
                            </li>
                            <li>
                                <div class="input-group">
                                    <span class="input-group-addon" ><i class="fa fa-2x fa-youtube"></i></span>
                                    <input type="text" class=" form-control social-input" name="youtube" style="height:48px"/>
                                    <span class="input-group-addon" ><input type="checkbox" checked="checked" name="youtube" class="social-check" /></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="buttons" style="max-width: 400px">
                        <div class="form-group">
                            <select class="form-control">
                                <option value="center">Alinear Boton al Centro</option>
                                <option value="left">Alinear Boton a la Izquierda</option>
                                <option value="right">Alinear Boton a la Derecha</option>
                            </select>
                        </div>
                        <ul id="buttonslist" class="list-group">
                            <li class="hide" style="padding:10px; border:1px solid #DADFE1; border-radius: 4px">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Button Title" name="btn_title"/>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-paperclip"></i></span>
                                    <input type="text" class="form-control"  placeholder="Add link to button" aria-describedby="basic-addon1" name="btn_link"/>
                                </div>
                                <div class="input-group" style="margin-top:10px">
                                    <label for="buttonStyle">Estilo del Botón</label>
                                    <div   class="color-circle buttonStyle" data-original-title="" title="">
                                        <i class="fa fa-font"></i>
                                    </div>
                                    <div class="stylebox hide" style="width:400px">
                                        <label>Tamaño del Botón</label>
                                        <div class="input-group " style="margin-bottom: 5px">
                                            <span class="input-group-addon button"  ><i class="fa fa-plus" style="  cursor : pointer;"></i></span>
                                            <input type="text" class="form-control text-center"  placeholder="Button Size"  name="ButtonSize"/>
                                            <span class="input-group-addon button"  ><i class="fa fa-minus" style="  cursor : pointer;"></i></span>
                                        </div>
                                        <label>Tamaño Letra </label>
                                        <div class="input-group " style="margin-bottom: 5px">

                                            <span class="input-group-addon font"  ><i class="fa fa-plus" style="  cursor : pointer;"></i></span>
                                            <input type="text" class="form-control text-center"  placeholder="Font Size"  name="FontSize"/>
                                            <span class="input-group-addon font"  ><i class="fa fa-minus" style="  cursor : pointer;"></i></span>
                                        </div>
                                        <div class="input-group background" style="margin-bottom: 5px">
                                            <span class="input-group-addon " style="width: 50px;">Color Fondo</span>
                                            <span class="input-group-addon picker" data-color="bg"></span>
                                        </div>

                                        <div class="input-group fontcolor" style="margin-bottom: 5px" >
                                            <span class="input-group-addon" style="width: 50px;">Color Letra</span>
                                            <span class="input-group-addon picker" data-color="font"></span>
                                            <script type="text/javascript">
                                                $('.picker').colpick({
                                                    layout: 'hex',
                                                    // colorScheme: 'dark',
                                                    onChange: function (hsb, hex, rgb, el, bySetColor) {
                                                        if (!bySetColor)
                                                            $(el).css('background-color', '#' + hex);
                                                            
                                                        var color = $(el).data('color');
                                                        var indexBnt = getIndex($(el).parent().parent().parent().parent().parent(), $('#buttonslist li')) - 1;
                                                        if (color === 'bg') {
                                                            $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexBnt + ') a')).css('background-color', '#' + hex);
                                                            $(el).parent().parent().parent().parent().find('div.color-circle').css('background-color', '#' + hex);
                                                            //fix td in email
                                                            $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexBnt + ')')).css('background-color', '#' + hex);
                                                        } else {
                                                            $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexBnt + ') a')).css('color', '#' + hex);
                                                            $(el).parent().parent().parent().parent().find('div.color-circle').css('color', '#' + hex);
                                                        }

                                                    },
                                                    onSubmit: function (hsb, hex, rgb, el) {
                                                        $(el).css('background-color', '#' + hex);
                                                        $(el).colpickHide();
                                                        var color = $(el).data('color');
                                                        var indexBnt = getIndex($(el).parent().parent().parent().parent().parent(), $('#buttonslist li')) - 1;
                                                        if (color === 'bg') {
                                                            $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexBnt + ') a')).css('background-color', '#' + hex);
                                                        } else {
                                                            $($('#' + $('#path').val()).find('table tbody tr td:eq(' + indexBnt + ') a')).css('color', '#' + hex);
                                                        }


                                                    }

                                                }).keyup(function () {
                                                    $(this).colpickSetColor(this.value);
                                                });
                                            </script>

                                        </div>
                                        <div class="text text-right">
                                            <a href="#" class="btn btn-xs btn-default confirm">Ok</a>
                                        </div>
                                    </div>
                                    <div class="fontselector" class="hide" style="min-width: 200px">
                                        <ul class="list-group" style="overflow: auto ;display: block;max-height: 200px" >
                                            <li class="list-group-item" style="font-family: arial">Arial</li>
                                            <li class="list-group-item" style="font-family: verdana">Verdana</li>
                                            <li class="list-group-item" style="font-family: helvetica">Helvetica</li>
                                            <li class="list-group-item" style="font-family: times">Times</li>
                                            <li class="list-group-item" style="font-family: georgia">Georgia</li>
                                            <li class="list-group-item" style="font-family: tahoma">Tahoma</li>
                                            <li class="list-group-item" style="font-family: pt sans">PT Sans</li>
                                            <li class="list-group-item" style="font-family: Source Sans Pro">Source Sans Pro</li>
                                            <li class="list-group-item" style="font-family: PT Serif">PT Serif</li>
                                            <li class="list-group-item" style="font-family: Open Sans">Open Sans</li>
                                            <li class="list-group-item" style="font-family: Josefin Slab">Josefin Slab</li>
                                            <li class="list-group-item" style="font-family: Lato">Lato</li>
                                            <li class="list-group-item" style="font-family: Arvo">Arvo</li>
                                            <li class="list-group-item" style="font-family: Vollkorn">Vollkorn</li>
                                            <li class="list-group-item" style="font-family: Abril Fatface">Abril Fatface</li>
                                            <li class="list-group-item" style="font-family: Playfair Display">Playfair Display</li>
                                            <li class="list-group-item" style="font-family: Yeseva One">Yeseva One</li>
                                            <li class="list-group-item" style="font-family: Poiret One">Poiret One</li>
                                            <li class="list-group-item" style="font-family: Comfortaa">Comfortaa</li>
                                            <li class="list-group-item" style="font-family: Marck Script">Marck Script</li>
                                            <li class="list-group-item" style="font-family: Pacifico">Pacifico</li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="text text-right" style="margin-top:5px">
                        <a href="#" id="saveElement" class="btn btn-info">Guardar</a>
                    </div>
                </div>
            </div>

            <div class="row" id="campoform">
                <div class="col-lg-2">
                    <p class="form-control-plaintext">Nombres: </p>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="titulo_plantilla" id="titulo_plantilla" placeholder="Ingrese El Nombres nombre para guardar su plantilla"  required>
                   
                </div>
              
            </div>
            <div class="row" id="campoform">
                
                <div class="col-lg-2">
                    <p class="form-control-plaintext">Campaña: </p>
                </div>
                <div class="col-lg-10">
                    
                    <select id="cmb_campana" name="cmb_campana" class="form-control">
                        <option value="" selected>SELECCIONE..</option>
                        @foreach($lstDatos as $value)
                        <option value="{{$value->id}}">{{$value->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <a href="#" class="btn btn-info btn-xs" id="edittamplate">Editar Fondo</a>
            <div id="tosave" data-id=""  data-paramone="11" data-paramtwo="22" data-paramthree="33">
               <table  width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #eeeeee" >
                   <tr>
                       <td width="100%" id="primary" class="main demo" align="center" valign="top" >
                            <div class="lyrow">
                               <div class="view">
                                   <div class="row clearfix">
                                       <!-- Content starts here-->
                                       <table width="640" class="preheader" align="center" cellspacing="0" cellpadding="0" border="0">
                                           <tr>
                                               <td align="left" class="preheader-text" width="420" style="padding: 15px 0px; font-family: Arial; font-size: 11px; color: #666666"></td>
                                               <td class="preheader-gap" width="20"></td>
                                               <td class="preheader-link" align="right" width="200" style="padding: 15px 0px; font-family: Arial; font-size: 11px; color: #666666">
                                                   ¿No ves las imágenes? [Linkversioneonline]
                                               </td>
                                           </tr>
                                       </table>
                                   </div>
                               </div>
                           </div>
                            <div class="column">
                               <div class="lyrow">
                                <a href="#close" class="remove label label-danger" style="padding:6px;"><i class="ti-trash"></i></a>
                                <span class="drag label label-info hide" style="padding:6px;"><i class="ti-move" style="color: #FFFFFF;"></i></span>
                                   <div class="view">
                                        <div class="row clearfix">
                                           <table width="640" class="main" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center" data-type='text-block' style="background-color: #FFFFFF;">
                                               <tbody>
                                                   <tr>
                                                       <td  class="block-text" align="left" style="padding:10px 50px 10px 50px;font-family:Arial;font-size:13px;color:#000000;line-height:22px">
                                                           <p style="margin:0px 0px 10px 0px;line-height:22px">
                                                               <center>
                                                                   <i class="fa fa-arrow-up fa-3x"></i> <br><br>
                                                                Modifíqueme o arrastre el contenido del correo electrónico en la parte superior o inferior.<br><br>
                                                               <i class="fa fa-arrow-down fa-3x"></i>
                                                               </center>
                                                           </p>
                                                       </td>
                                                   </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                                <div class="lyrow">
                                   <div class="view">
                                       <div class="row clearfix">
                                           <!-- Content starts here-->
                                           <table width="640" class="preheader" align="center" cellspacing="0" cellpadding="0" border="0">
                                               <tr>
                                                   <td align="left" class="preheader-text" width="420" style="padding: 15px 0px; font-family: Arial; font-size: 11px; color: #666666"></td>
                                                   <td class="preheader-gap" width="20"></td>
                                                   <td class="preheader-link" align="right" width="200" style="padding: 15px 0px; font-family: Arial; font-size: 11px; color: #666666">
                                                       [Quitar la Suscripción]
                                                   </td>
                                               </tr>
                                           </table>
                                       </div>
                                   </div>
                               </div>
 
                            </div>
 
                        </td>
                   </tr>
               </table>
            </div>
            <div id="download-layout">

            </div>
        </div>
        <!--/row-->
        <!-- Modal  de Previsualizacion -->
        <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="min-width:120px">
                    <div class="modal-header">
                        <input id="httphref" type="text" name="href" value="http://localhost/Email-Editor/template.html" class="form-control" />
                    </div>
                    <div class="modal-body" align="center">
                        <div class="btn-group  previewActions">
                            <a class="btn btn-default btn-sm active" href="#">Celuar</a>
                            <a class="btn btn-default btn-sm " href="#">Tablet 7'</a>
                            <a class="btn btn-default btn-sm " href="#">Tablet 11'</a>
                        </div>
                        <iframe id="previewFrame"  class="iphone" src="" ></iframe>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <textarea id="imageid" class="hide"></textarea>
        <textarea id="download" class="hide"></textarea>
        <textarea id="selector" class="hide"></textarea>
        <textarea  id="path" class="hide"></textarea>
        <!-- Modal de Imagenes-->
        
        <form method="post" action="" name="ftienda" enctype="multipart/form-data">

            <input name="proceso" type="hidden">
            <input name="nombre" id="nombre" type="hidden">
            <input name="cmb_campana" id="campana" type="hidden">
            <input name="contenido_expo" id="contenido_expo" type="hidden">
            <textarea name="contenido" id="contenido" style="display: none;"></textarea>
        </form>
    </body>
    <script>
        function crear_temp(){
            var e = "";
            $("#download-layout").html($("#tosave").html());
            var t = $("#download-layout");
            t.find(".preview, .configuration, .drag, .remove").remove();
            t.find("a.button-1").each(function () {
                $(this).attr('href', $(this).data('href'));
            });
            var clone = t.find('td#primary').parent().parent().parent();
            console.log(clone);

            var preheader = t.find('td#primary .lyrow .view .row table.preheader').parent().html();
            var header = "";
            var body = '';
            t.find('div.column .lyrow .view .row').each(function () {
                var self = $(this);
                body += self.html();
            });
            var contenido_html = body;
            document.getElementById('contenido').value = contenido_html;
        }
        function temporal_email(){
            
            if(document.getElementById('titulo_plantilla').value == ""){
                resultvalidacion = false;
                 document.getElementById('titulo_plantilla').focus();
                swal("Debes ingresar el Nombre de la plantilla caso contrario no podras hacer la prueba ");
                return; 
                
            }else{
                crear_temp();
                $.ajax({
                        type: 'POST',
                        data: {contenido:document.getElementById('contenido').value},
                        url: "crear-temporal.php?titulo="+document.getElementById('titulo_plantilla').value,
                    });
                return;
            }
        }
        function Exportar(){
            crear_temp();
            //document.ftienda.action = "nueva-plantilla.php";
            //document.ftienda.proceso.value = "Preview";   
            //var titulo    = document.getElementById('titulo_plantilla').value;
            //document.ftienda.nombre.value = titulo;
                if(document.getElementById('titulo_plantilla').value == ""){
                    resultvalidacion = false;
                    document.getElementById('titulo_plantilla').focus();
                    swal("Debes ingresar el Nombre de la plantilla");
                return;
                }else{  
                    //document.ftienda.submit();
                        $.ajax({
                        type: 'POST',
                        data: {contenido:document.getElementById('contenido').value, condicion:"Preview"},
                        url: "crear-temporal.php?titulo="+document.getElementById('titulo_plantilla').value,
                        success: function (data, status, xhr) {// success callback function
                           window.open(data, '_blank'); 
                        }
                       
                    });
                return;
                }
        }
     /*   function Guardar(){
            var contenido_html  = $("#tosave").html();
            var titulo          = document.getElementById('titulo_plantilla').value;
            document.ftienda.action = "nueva-plantilla.php";
            document.ftienda.proceso.value = "Registrar";
            document.ftienda.nombre.value = titulo;
            document.ftienda.contenido.value = contenido_html;
            var e = "";
            $("#download-layout").html($("#tosave").html());
            var t = $("#download-layout");
            t.find(".preview, .configuration, .drag, .remove").remove();
            t.find("a.button-1").each(function () {
                $(this).attr('href', $(this).data('href'));
            });
            var clone = t.find('td#primary').parent().parent().parent();
           console.log(clone);
            var preheader   = t.find('td#primary .lyrow .view .row table.preheader').parent().html();
            var header      = "";
            var body        = '';
            t.find('div.column .lyrow .view .row').each(function () {
                var self = $(this);
                body += self.html();
            });
            var contenido_export = body;
            document.ftienda.contenido_expo.value = contenido_export
            if(document.ftienda.nombre.value == ""){
                resultvalidacion = false;
                 document.getElementById('titulo_plantilla').focus();
                swal("Debes ingresar el Nombre de la plantilla");
                return;
            }else{  
                document.ftienda.submit();
            }
        }*/
    
</script>
<div class="modal fade" id="ModalImagenes" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border bottom">
                    <div><h4 class="modal-title">Subir Imagen</h4></div>
                    <div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div  id="DatosModalImagenes">
                        <form action="{{ url('imagen_archivo') }}" class="dropzone" id="my-awesome-dropzone" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        </form>
                        <div id="contenido" style="display: none;"></div>
                        <div class="btn-group" style="width: 100%;">
                            <button type="button" class="btn btn btn-info" style="width: 100% !important;" onClick="ultimo_archivo();"><i class="ti-email"></i> Aplicar imagen</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-border">
                    <div class="text-right">
                        <button class="btn btn-success" onclick="cerrarModal();">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</html>








