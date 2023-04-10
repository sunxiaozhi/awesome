
ORDER BY 后可加2个字段，用英文逗号隔开。

f1用升序， f2降序，sql该这样写

ORDER BY f1, f2 DESC

也可以这样写，更清楚：

ORDER BY f1 ASC, f2 DESC

如果都用降序，必须用两个desc

ORDER BY f1 DESC, f2 DESC