<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('email.title')</title>
    {{--
        For gmail compatibility, including CSS styles in head/body are stripped out therefore styles need to be inline.
        These variables contain rules which are added to the template inline.
        !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
    --}}
    @php( $styles=[
            'body'               => "
                background-color: #f6f6f6;
                font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
            ",
            'wrapper'            => "
                width:100%;
                -webkit-text-size-adjust:none !important;
                margin:0;
                padding: 70px 0 70px 0;
            ",
            'template_container' => "
                box-shadow:0 0 0 1px #f3f3f3 !important;
                border-radius:3px !important;
                background-color: #ffffff;
                border: 1px solid #e9e9e9;
                border-radius:3px !important;
                padding: 20px;
            ",
            'template_header'    => "
                color: #00000;
                border-top-left-radius:3px !important;
                border-top-right-radius:3px !important;
                border-bottom: 0;
                font-weight:bold;
                line-height:100%;
                text-align: center;
                vertical-align:middle;
            ",
            'body_content'       => "
                border-radius:3px !important;
                font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
            ",
            'body_content_inner' => "
                color: #000000;
                font-size:14px;
                font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
                line-height:150%;
                text-align:left;
            ",
            'header_content_h1'  => "
                color: #000000;
                margin:0;
                padding: 28px 24px;
                display:block;
                font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
                font-size:32px;
                font-weight: 500;
                line-height: 1.2;
            ",
            'template_footer'    => "
                border-top:0;
                -webkit-border-radius:3px;
                ",
                'credit'             => "
                border:0;
                color: #000000;
                font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
                font-size:12px;
                line-height:125%;
                text-align:center;
                "
    ])
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="{{ $styles['body'] }}">
<div style="{{ $styles['wrapper'] }}">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tr>
            <td align="center" valign="top">
                <div id="template_header_image">
                    <p style="margin-top:0;">
                        <img src="{{ url('assets/img/emails/logo.png') }}" alt="{{ config('app.name') }}"/></p>
                </div>
                <table border="0" cellpadding="0" cellspacing="0" width="520" id="template_container" style="{{ $styles['template_container'] }}">
                    <tr>
                        <td align="center" valign="top">
                            <!-- Header -->
                            <table border="0" cellpadding="0" cellspacing="0" width="520" id="template_header" style="{{ $styles['template_header'] }}" bgcolor="#ffffff">
                                <tr>
                                    <td>
                                        <h1 style="{{ $styles['header_content_h1'] }}">@yield('email.title')</h1>
                                    </td>
                                </tr>
                            </table>
                            <!-- End Header -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- Body -->
                            <table border="0" cellpadding="0" cellspacing="0" width="520" id="template_body">
                                <tr>
                                    <td valign="top" style="{{ $styles['body_content'] }}">
                                        <!-- Content -->
                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                            <tr>
                                                <td valign="top">
                                                    <div style="{{ $styles['body_content_inner'] }}">
                                                        @yield('email.content')
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- End Content -->
                                    </td>
                                </tr>
                            </table>
                            <!-- End Body -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- Footer -->
                            <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer" style="{{ $styles['template_footer'] }}">
                                <tr>
                                    <td valign="top">
                                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                            <tr>
                                                <td colspan="2" valign="middle" id="credit" style="{{ $styles['credit'] }}">
                                                    <p><a href="{{ url('/') }}">{{ config('app.name') }}</a></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- End Footer -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>