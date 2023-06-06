if (typeof window["edsScripts"] == "undefined") {
    var all_scripts = document.getElementsByTagName("script");
    var eds_script_root = all_scripts[all_scripts.length - 1].src.replace(/[^\/]*\.js$/, "");
    window.addEvent("domready", function() {
        edsScripts = new edsScripts
    });
    var edsScripts = new Class({      
        loadajax: function(url, succes, fail, query, timeout) {
            if (url.substr(0, 9) != "index.php") {
                url = url.replace("http://", "");
                url = "index.php?eds_qp=1&url=" +
                    escape(url);
                if (timeout) url += "&timeout=" + timeout
            }
            var myXHR = (new Request({
                method: "post",
                url: url,
                onSuccess: function(data) {
                    if (succes) eval(succes + ";")
                },
                onFailure: function(data) {
                    if (fail) eval(fail + ";")
                }
            })).send(query)
        },
        displayVersion: function(data, extension, version, is_pro) {
            if (!data) return;
            var xml = edsScripts.getObjectFromXML(data);
            if (!xml) return;
            if (typeof xml[extension] == "undefined") return;
            dat = xml[extension];
            if (!dat || (typeof dat["version"] == "undefined" || !dat["version"])) return;
            var new_version = dat["version"];
            var compare = edsScripts.compareVersions(version, new_version);
            if (compare != "<") return;
            el = document.getElement("#eds_newversionnumber_" + extension);
            if (el) el.set("text", new_version);
            el = document.getElement("#eds_version_" + extension);
            if (el) {
                el.setStyle("display", "block");
                (function() {
                    $each(document.getElements("div.jpane-slider"), function(el) {
                        if (el.getStyle("height") != "0px") el.setStyle("height", "auto")
                    })
                }).delay(100)
            }
        },
        getObjectFromXML: function(data) {
            if (!data) return;
            var xml = null;
            if (window.DOMParser) {
                var parser = new DOMParser;
                xml = parser.parseFromString(data,
                    "text/xml")
            } else {
                xml = new ActiveXObject("Microsoft.XMLDOM");
                xml.async = "false";
                xml.loadXML(data)
            }
            var obj = [];
            for (var i = 0; i < xml.getElementsByTagName("extension").length; i++) {
                ext = xml.getElementsByTagName("extension")[i];
                el = [];
                for (var j = 0; j < ext.childNodes.length; j++) {
                    node = ext.childNodes[j];
                    if (node && node.firstChild) el[node.nodeName.toLowerCase()] = String(node.firstChild.nodeValue).trim()
                }
                if (typeof el.alias !== "undefined") obj[el.alias] = el;
                if (typeof el.extname !== "undefined" && el.extname != el.alias) obj[el.extname] =
                    el
            }
            return obj
        },
        compareVersions: function(num1, num2) {
            num1 = num1.split(".");
            num2 = num2.split(".");
            var let1 = "";
            var let2 = "";
            max = Math.max(num1.length, num2.length);
            for (var i = 0; i < max; i++) {
                if (typeof num1[i] == "undefined") num1[i] = "0";
                if (typeof num2[i] == "undefined") num2[i] = "0";
                let1 = num1[i].replace(/^[0-9]*(.*)/, "$1");
                num1[i] = parseInt(num1[i]);
                let2 = num2[i].replace(/^[0-9]*(.*)/, "$1");
                num2[i] = parseInt(num2[i]);
                if (num1[i] < num2[i]) return "<";
                else if (num1[i] > num2[i]) return ">"
            }
            if (let2 && (!let1 || let1 > let2)) return ">";
            else if (let1 &&
                (!let2 || let1 < let2)) return "<";
            else return "="
        }
    });
};