(self.webpackChunk_am5 = self.webpackChunk_am5 || []).push([
  [4583],
  {
    2250: function (e, r, l) {
      "use strict";
      l.r(r),
        l.d(r, {
          am5themes_Material: function () {
            return f;
          },
        });
      var o = l(5125),
        t = l(1112);
      const f = (function (e) {
        function r() {
          return (null !== e && e.apply(this, arguments)) || this;
        }
        return (
          (0, o.ZT)(r, e),
          Object.defineProperty(r.prototype, "setupDefaultRules", {
            enumerable: !1,
            configurable: !0,
            writable: !0,
            value: function () {
              e.prototype.setupDefaultRules.call(this),
                this.rule("ColorSet").setAll({
                  colors: [
                    t.Il.fromHex(0x21fc72),
                    t.Il.fromHex(0xdc3545),
                    t.Il.fromHex(0xe5efff),
                    t.Il.fromHex(0x0066ff),
                  ],
                  reuse: !0,
                });
            },
          }),
          r
        );
      })(l(3409).Q);
    },
  },
  function (e) {
    "use strict";
    var r = (2250, e((e.s = 2250))),
      l = window;
    for (var o in r) l[o] = r[o];
    r.__esModule && Object.defineProperty(l, "__esModule", { value: !0 });
  },
]);
//# sourceMappingURL=Material.js.map
