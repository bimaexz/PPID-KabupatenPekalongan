(function($) {
    if (typeof window["edsScripts"] == "undefined") {
        $(document).ready(function() {
            $("div.control-group > div").each(function(i, el) {
                if ($(el).html().trim() == "") $(el).remove()
            });
            $("div.control-group").each(function(i, el) {
                if ($(el).html().trim() == "") $(el).remove()
            });
            $("div.control-group > div.hide").each(function(i, el) {
                $(el).parent().css("margin", 0)
            })
        });
        edsScripts = {
            loadajax: function(url, succes, fail, query, timeout, dataType) {
            	if (url.substr(0, 9) != "index.php") {
                    url = url.replace("http://", "");
                    url = "index.php?eds_qp=1&url=" +
                        escape(url);
                    if (timeout) url += "&timeout=" + timeout
                }
            	dt = dataType ? dataType : "";
                $.ajax({
                    type: "post",
                    url: url,
                    dataType: dt,
                    success: function(data) {                    	
                        if (succes) eval(succes + ";")
                    },
                    error: function(data) {
                    	if (fail) eval(fail + ";")
                    }
                })
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
                el = $("#eds_newversionnumber_" + extension);                
                if (el) el.text(new_version);
                el = $("#eds_version_" + extension);
                if (el) {
                    el.css("display", "block");
                    el.parent().removeClass("hide")
                }
            },
            getObjectFromXML: function(xml) {
                if (!xml) return;
                var obj = [];
                $(xml).find("extension").each(function() {
                    el = [];
                    $(this).children().each(function() {
                        el[this.nodeName.toLowerCase()] = String($(this).text()).trim()
                    });
                    if (typeof el.alias !== "undefined") obj[el.alias] = el;
                    if (typeof el.extname !== "undefined" && el.extname != el.alias) obj[el.extname] = el
                });
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
                else if (let1 && (!let2 || let1 < let2)) return "<";
                else return "="
            }           
        }
    }
   
})(jQuery);