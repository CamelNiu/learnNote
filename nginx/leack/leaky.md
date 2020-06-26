### 漏桶算法-php实现

##### 1，概览

	最近研究nginx的限流,limit_req_zone。
	其功能就是限制大访问量下的请求数量，防止服务器故障。

	核心逻辑就是：
		1，给nginx配置一个处理请求速率。比如每秒处理5个请求。
		2，大访问量下没有处理到的请求进行排队等待。
		3，给排队的请求配置一个长度，超过了长度的请求直接返回错误 。比如设置队列长度为5，有5个请求正在排队的情况下，
		   下一个请求直接返回错误。

	比较感兴趣它的实现,查阅资料发现利用了漏桶算法。就顺便带着学习一下。
		漏桶算法的原理：

			漏桶有一定的容量，给漏桶注水，当单位时间内注入水量大于流出水量，漏桶内积累的水就会越来越多，直到溢出。

			就好比大批量请求访问nginx相当于注水，nginx根据配置按照固定速率处理请求当做排水。
			漏桶容量就好比配置给nginx的队列长度。当漏桶发生溢出，则禁止请求进入，直接返回错误。




##### 2，实现

	
	/**
	 * [leaky php实现漏桶算法]
	 * @Author   [NiuShao   <camel_niu@163.com> <qq:370574131>]
	 * @DateTime 2020-06-26
	 * @param    [type]     $contain            [int 桶的总容量]
	 * @param    [type]     $addNum             [int 每次注入桶中的水量]
	 * @param    [type]     $leakRate           [int 桶中漏水的速率,秒为单位。例如2/s,3/s]
	 * @param    integer    &$water             [int 当前水量]
	 * @param    integer    &$preTime           [int 时间戳,记录的上次漏水时间]
	 * @return   [type]                         [bool,返回可否继续注入true/false]
	 */
	function leaky($contain,$addNum,$leakRate,&$water=0,&$preTime=0)
	{
	    //参数赋值
	    //首次进入默认当前水量为0
	    $water = empty($water) ? 0 : $water;
	    //首次进入默认上次漏水时间为当前时间
	    $preTime = empty($water) ? time() : $preTime;
	    $curTime = time();
	    //上次结束到本次开始，流出去的水
	    $leakWater = ($curTime-$preTime)*$leakRate;
	    //上次结束时候的水量减去流出去的水，也就是本次初始水量
	    $water = $water-$leakWater;
	    //水量不可能为负，漏出大于进入则水量为0
	    $water = ( $water>=0 ) ? $water : 0 ;
	    //更新本次漏完水的时间
	    $preTime = $curTime;
	    //水小于总容量则可注入，否则不可注入
	    if( ($water+$addNum) <= $contain ){
	        $water += $addNum;
	        return true;
	    }else{
	        return false;
	    }
	
	}
	
	/**
	 * 测试
	 * @var integer
	 */
	for($i=0;$i<500;$i++){
	    $res = leaky(50,1,5,$water,$timeStamp);
	    var_dump($res);
	    usleep(50000);
	}


##### 3，说明：

	上面的漏桶算法更加的一般化了，容器总量，注水量，排水量都可以随机设置。
	为了完全使用php实现，时间参数$preTime和当前水量$water都利用了php的引用赋值。作为全局变量。
	测试过程利用率循环机制给漏桶注水。
	
	在实际生产环境下如果要用php代码做限流，容器总量，注水排水都不能为小数。
	并且对时间参数和当前水量建议用redis缓存或者文件缓存来进行保存。
	因为(nginx+php-fpm)架构下，每次请求都是独立的，所有变量都会被释放。
	