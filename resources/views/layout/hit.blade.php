<script>
    let url = new URL(document.URL);
    let replacePathname = (new URL(url.origin + "{{config("app.url")}}")).pathname;
    let pathname = url.pathname.replace(replacePathname, "");

    let allowedPaths = ["/", "/anime", "/search", "/watch", "/watchlist", "/account"];

    if (allowedPaths.filter(obj => obj === pathname).length) {

        let userAgent = navigator.userAgent;
        let os;
    
        if (userAgent.indexOf("Windows") !== -1) {
            os = "Windows";
        } else if (userAgent.indexOf("Mac") !== -1) {
            os = "MacOS";
        } else if (userAgent.indexOf("Android") !== -1) {
            os = "Android";
        } else if (userAgent.indexOf("iOS") !== -1) {
            os = "iOS";
        } else if (userAgent.indexOf("Linux") !== -1) {
            os = "Linux";
        } else {
            os = "Unknown";
        }
    
        let ip;
        if (Cookies.get("ipify")) {
            ip = Cookies.get("ipify");
            fetch("{{config("app.url")}}/api/hit", {
                method: "post",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    ip: ip,
                    os: os,
                    path: pathname,
                    screenx: document.documentElement.clientWidth
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            });
        } else {
            $.getJSON('https://api.ipify.org?format=json', function(data){
                ip = data.ip;
                Cookies.set('ipify', data.ip, { sameSite: "strict" });
                fetch("{{config("app.url")}}/api/hit", {
                    method: "post",
                    body: JSON.stringify({
                        "_token": "{{ csrf_token() }}",
                        ip: ip,
                        os: os,
                        path: pathname,
                        screenx: document.documentElement.clientWidth
                    }),
                    headers: {
                        "Content-Type": "application/json"
                    }
                });
            });
        }

    }
    

</script>