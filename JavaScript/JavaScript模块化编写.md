我们希望别人的代码尽量少的影响到自己的代码，同时我们的代码也尽量少的影响到别人的代码。因此我们就需要对自己的js代码进行模块化，防止产生更多的全局变量。

现在我们写代码不再是一个人包办所有的活儿，都是在多人合作的情况下完成的。我们只需要负责自己的这块就行了，而且我们也希望别人的代码尽量少的影响到自己的代码，同时我们的代码也尽量少的影响到别人的代码。因此我们就需要对自己的js代码进行模块化，防止产生更多的全局变量！

对象形式写法

```
var test = {
    top:0,
    left:0,

    init:function(){
        var self = this;
        console.log("top:"+self.top);
        self.check();
    },

    check:function(){
        var self = this;
        console.log("left:"+self.left);
    }
};
```

立即执行函数写法
```
var test = (function(){
    var top  = 0;
    var left = 0;

    function getTop(){
        return top;
    }

    return {
        getTop:getTop
    }
})();
```

prototype写法
```
function Hello(options){
    this.config = {
        top:0,
        left:0
    };
    this.init(options);
}

Hello.prototype = {
    constructor:Hello,

    init:function(options){
        this.config = $.extend(this.config, options || {});
        var self    = this,
            _config = self.config,
            _cache  = self.cache;

        self._bindEnv();
    },

    _bindEnv:function(){
        var self = this,
            _config = self.config,
            _cache  = self.cache;

        console.log(self.config);
    }
}
```

总结

this不存在Object对象中的,它只存在一个Function类型的函数中

this指向使用new操作符实例化其所在函数的实例对象

this还指向调用其所在函数的对象