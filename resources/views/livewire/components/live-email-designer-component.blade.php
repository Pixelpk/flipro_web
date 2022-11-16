<div>
    @php
    $url = '/builder/template/stream?id=' . $_GET['id'];
    @endphp
    <script>
        var editor;
        var params = new URLSearchParams(window.location.search);
        var templates = [
            {"name":"Blank","url":"/email/design?id=6037a0a8583a7"},
            {"name":"Pricing Table","url":"/email/design?id=6037a2135b974"},
            {"name":"Listing & Tables","url":"/email/design?id=6037a2250a3a3"},
            {"name":"Forms Building","url":"/email/design?id=6037a23568208"},
            {"name":"1-2-1 column layout","url":"/email/design?id=6037a2401b055"},
            {"name":"1-2 column layout","url":"/email/design?id=6037a24ebdbd6"},
            {"name":"1-3-1 column layout","url":"/email/design?id=6037a25ddce80"},
            {"name":"1-3-2 column layout","url":"/email/design?id=6037a26b0a286",},
            {"name":"1-3 column layout","url":"/email/design?id=6037a275bf375"},
            {"name":"One column layout","url":"/email/design?id=6037a28418c95"},
            {"name":"2-1-2 column layout","url":"/email/design?id=6037a29a35e05"},
            {"name":"2-1 column layout","url":"/email/design?id=6037a2aa315d4"},
            {"name":"Two columns layout","url":"/email/design?id=6037a2b67ed27"},
            {"name":"3-1-3 column layout","url":"/email/design?id=6037a2c3d7fa1"},
            {"name":"Three columns layout","url":"/email/design?id=6037a2dcb6c56"}
        ];

        var tags = [
            {type: 'label', tag: '{name}'},
            {type: 'label', tag: '{email}'},
            {type: 'label', tag: '{phone}'},
            {type: 'label', tag: '{address}'}
        ];

        $( document ).ready(function() {
            var strict = true;

            if(params.get('type') == 'custom') {
                strict = false;
            }

            editor = new Editor({
                strict: strict, // default == true
                showInlineToolbar: true, // default == true
                root: '/builderjs/dist/',
                url: '<?php echo $url ?>',
                urlBack: window.location.origin,
                uploadAssetUrl: '/builder/assets/save',
                uploadAssetMethod: 'POST',
                uploadTemplateUrl: 'upload.php',
                uploadTemplateCallback: function(response) {
                    window.location = response.url;
                },
                saveUrl: '/builder/template/save',
                saveMethod: 'POST',
                data: {
                    _token: 'CSRF_TOKEN',
                    template_id: '<?php echo $_GET['id'] ?>'
                },
                templates: templates,
                tags: tags,
                changeTemplateCallback: function(url) {
                    window.location = url;
                },

                /*
                    Disable features: 
                    change_template|export|save_close|footer_exit|help
                */
                // disableFeatures: [ 'change_template', 'export', 'save_close', 'footer_exit', 'help' ], 

                // disableWidgets: [ 'HeaderBlockWidget' ], // disable widgets
                export: {
                    url: 'export.php'
                },
                backgrounds: [
                    '/builderjs/assets/image/backgrounds/images1.jpg',
                    '/builderjs/assets/image/backgrounds/images2.jpg',
                    '/builderjs/assets/image/backgrounds/images3.jpg',
                    '/builderjs/assets/image/backgrounds/images4.png',
                    '/builderjs/assets/image/backgrounds/images5.jpg',
                    '/builderjs/assets/image/backgrounds/images6.jpg',
                    '/builderjs/assets/image/backgrounds/images9.jpg',
                    '/builderjs/assets/image/backgrounds/images11.jpg',
                    '/builderjs/assets/image/backgrounds/images12.jpg',
                    '/builderjs/assets/image/backgrounds/images13.jpg',
                    '/builderjs/assets/image/backgrounds/images14.jpg',
                    '/builderjs/assets/image/backgrounds/images15.jpg',
                    '/builderjs/assets/image/backgrounds/images16.jpg',
                    '/builderjs/assets/image/backgrounds/images17.png'
                ],
                loaded: function() {
                    var thisEditor = this;

                    if (typeof(WidgetManager) !== 'undefined') {
                        var widgets = WidgetManager.init();

                        widgets.forEach(function(widget) {
                            thisEditor.addContentWidget(widget, 0, 'Template Content');
                        });
                    }
                }
            });

            editor.init();
        });
    </script>

    <style>
        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 30px;
            height: 30px;
            margin: 4px;
            border-radius: 80%;
            border: 2px solid #aaa;
            border-color: #007bff transparent #007bff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</div>