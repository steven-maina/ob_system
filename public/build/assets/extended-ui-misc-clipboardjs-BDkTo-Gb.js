(function(){const c=[].slice.call(document.querySelectorAll(".clipboard-btn"));ClipboardJS?c.map(function(o){new ClipboardJS(o).on("success",function(i){i.action=="copy"&&toastr.success("","Copied to Clipboard!!")})}):c.map(function(o){o.setAttribute("disabled",!0)})})();