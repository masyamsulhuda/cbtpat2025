WebFont.load({
    custom: {
        "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
        urls: [base_url_js +'___/css/fonts.min.css']
    },
    active: function() {
        sessionStorage.fonts = true;
    }
});