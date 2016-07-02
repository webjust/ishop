<?php 
	include('./home/public/header.php');
	require_once('./comm/conn.php');

	/*新品遍历，最新添加的产品，按照时间排序，date_added*/
	$sql = "SELECT * FROM `shop_product` ORDER BY `date_added` DESC LIMIT 0, 10";
	$sql = "SELECT * FROM `shop_product` WHERE `status` = 1 ORDER BY `date_added` DESC LIMIT 0, 10";
	$res_new = mysqli_query($conn, $sql);
	if ($res_new) {
		while($row = mysqli_fetch_assoc($res_new)){
			$list_new[] = $row;
		}
	}
	mysqli_free_result($res_new);

	/*热销品遍历，按照效率排序，solded*/
	$sql = "SELECT * FROM `shop_product` WHERE `status` = 1 ORDER BY `solded` DESC LIMIT 10";
	$res_sold = mysqli_query($conn, $sql);
	if ($res_sold) {
		while($row = mysqli_fetch_assoc($res_sold)){
			$list_sold[] = $row;
		}
	}
	mysqli_free_result($res_sold);

?>
	<!-- BEGIN 首页 -->
	<div id="first">
		<!-- 导航的位置 -->
		<div style="width:240px; height:570px; float:left;"></div>
		<div id="banner">
			<!-- 幻灯片开始 -->
			<div class="big">
			<div id="container">
			    <div id="list" style="left: -960px;">
			        <img src="./home/images/banner01.jpg" alt="5" width="960" />
			        <img src="./home/images/banner01.jpg" alt="1" width="960" />
			        <img src="./home/images/banner02.jpg" alt="2" width="960" />
			        <img src="./home/images/banner03.jpg" alt="3" width="960" />
			        <img src="./home/images/banner04.jpg" alt="4" width="960" />
			        <img src="./home/images/banner05.jpg" alt="5" width="960" />
			        <img src="./home/images/banner05.jpg" alt="1" width="960" />
			    </div>
			    <div id="buttons">
			        <span index="1" class="on"></span>
			        <span index="2"></span>
			        <span index="3"></span>
			        <span index="4"></span>
			        <span index="5"></span>
			    </div>
			    <a href="javascript:;" id="prev" class="arrow">&lt;</a>
			    <a href="javascript:;" id="next" class="arrow">&gt;</a>
			</div>
			</div>
			<!-- 幻灯片结束 -->
			<div class="small">
				<ul>
					<li class="first"><a href="bestseller.php"><img src="./home/images/banner_01.jpg" width="182" height="145" title="1"></a></li>
					<li><a href="catalog.php?cid=73"><img src="./home/images/banner_02.jpg" width="182" height="145" title="2"></a></li>
					<li><a href="catalog.php?cid=73"><img src="./home/images/banner_03.jpg" width="182" height="145" title="3"></a></li>
					<li><a href="catalog.php?cid=73"><img src="./home/images/banner_04.jpg" width="182" height="145" title="4"></a></li>
					<li style="margin:0;"><a href="catalog.php?cid=73"><img src="./home/images/banner_05.jpg" width="182" height="145" title="5"></a></li>
				</ul>
			</div>
		</div>
	</div>

	<div id="main">
		<div class="module">
			<div class="tit">
				<h2>正在流行<span class="subtit">流行元素 权威榜单</span></h2>
			</div>
			<div class="content">
				<div class="img-list">
					<ul>
						<li><a href="./catalog.php?cid=73"><img src="./home/images/3-1.jpg" width="183" /></a></li>
						<li><a href="catalog.php?cid=74"><img src="./home/images/3-2.png" width="183" /></a></li>
						<li><a href="catalog.php?cid=69"><img src="./home/images/3-3.png" width="183" /></a></li>
						<li><a href="catalog.php?cid=68"><img src="./home/images/3-4.png" width="183" /></a></li>
						<li><a href="catalog.php?cid=76"><img src="./home/images/3-5.jpg" width="183" /></a></li>
						<li style="margin-right:0;"><a href="catalog.php?cid=72"><img src="./home/images/3-6.png" width="183" /></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="module">
			<div class="tit">
				<h2>新品精选<span class="subtit">尖货来袭 要你好看</span></h2>
			</div>
			<div class="pro-list">
				<ul>
					<?php $i=1; foreach($list_new as $val): ?>
					<!-- 路径p_image下，如果图片不存在就去p400_image路径寻找 -->
					<?php
						$picurl = "./comm/p_image/{$val['image']}";
						// echo $picurl;
						if (file_exists($picurl)) {
							$picurl = $picurl;
						} else{
							$picurl = "./comm/p400_image/{$val['image']}";
						}
					?>
					<li<?php echo ($i%5==0)?" class='last'":NULL ?>>
						<div class="p-img">
							<a href="./product.php?id=<?php echo $val['id'] ?>"><img src="<?php echo $picurl; ?>" width="224" height="340" alt="<?php echo $val['name'] ?>" title="<?php echo $val['name'] ?>"></a>
						</div>
						<div class="p-price">
							<span class="price">&yen; <?php echo $val['price'] ?></span>
							<span class="zan"><?php echo $val['viewed'] ?></span>
						</div>
						<div class="p-name"><a href="./product.php?id=<?php echo $val['id'] ?>"><?php echo $val['name'] ?></a></div>
					</li>
					<?php $i++; endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
		<div class="module">
			<div class="tit">
				<h2>为你精选<span class="subtit">为您精挑细选的宝贝</span></h2>
			</div>
			<div class="pro-list">
				<ul>
					<?php $i=1; foreach($list_sold as $val): ?>
					<!-- 路径p_image下，如果图片不存在就去p400_image路径寻找 -->
					<?php
						$picurl = "./comm/p_image/{$val['image']}";
						// echo $picurl;
						if (file_exists($picurl)) {
							$picurl = $picurl;
						} else{
							$picurl = "./comm/p400_image/{$val['image']}";
						}
					?>					
					<li<?php echo ($i%5==0)?" class='last'":NULL ?>>
						<div class="p-img">
							<a href="./product.php?id=<?php echo $val['id'] ?>"><img src="<?php echo $picurl; ?>" width="224" height="340" alt="<?php echo $val['name'] ?>" title="<?php echo $val['name'] ?>"></a>
						</div>
						<div class="p-price">
							<span class="price">￥ <?php echo $val['price'] ?></span>
							<span class="zan"><?php echo $val['viewed'] ?></span>
						</div>
						<div class="p-name"><a href="./product.php?id=<?php echo $val['id'] ?>"><?php echo $val['name'] ?></a></div>
					</li>
					<?php $i++; endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!-- END 首页 -->
<?php 
	include('./home/public/footer.php');
?>
<script>
//全局变量
var oAd     = document.getElementById('ad');
var oAdcon  = document.getElementById('adcon');

var h = 0;
var step = 5;
var maxH = oAdcon.height;
function adDown(){
	oAd.style.height = h +'px';
    oAd.style.display = 'block';
	if(h<maxH){
		h+=step;
		setTimeout(adDown,1);
		}else{			
			setTimeout(adUp,3000);
			}
}
function adUp(){
	if(h>0){
		h-=step;
		oAd.style.height = h +'px';
		setTimeout(adUp,1);
		}
	}
setTimeout(adDown,3000);
</script>

<!-- 幻灯片JS -->
<script type="text/javascript">

    window.onload = function () {
        var container = document.getElementById('container');
        var list = document.getElementById('list');
        var buttons = document.getElementById('buttons').getElementsByTagName('span');
        var prev = document.getElementById('prev');
        var next = document.getElementById('next');
        var index = 1;
        var len = 5;
        var animated = false;
        var interval = 3000;
        var timer;


        function animate (offset) {
            if (offset == 0) {
                return;
            }
            animated = true;
            var time = 300;
            var inteval = 10;
            var speed = offset/(time/inteval);
            var left = parseInt(list.style.left) + offset;

            var go = function (){
                if ( (speed > 0 && parseInt(list.style.left) < left) || (speed < 0 && parseInt(list.style.left) > left)) {
                    list.style.left = parseInt(list.style.left) + speed + 'px';
                    setTimeout(go, inteval);
                }
                else {
                    list.style.left = left + 'px';
                    if(left>-450){
                        list.style.left = -960 * len + 'px';
                    }
                    if(left<(-960 * len+1)) {
                        list.style.left = '-960px';
                    }
                    animated = false;
                }
            }
            go();
        }

        function showButton() {
            for (var i = 0; i < buttons.length ; i++) {
                if( buttons[i].className == 'on'){
                    buttons[i].className = '';
                    break;
                }
            }
            buttons[index - 1].className = 'on';
        }

        function play() {
            timer = setTimeout(function () {
                next.onclick();
                play();
            }, interval);
        }
        function stop() {
            clearTimeout(timer);
        }

        next.onclick = function () {
            if (animated) {
                return;
            }
            if (index == 5) {
                index = 1;
            }
            else {
                index += 1;
            }
            animate(-960);
            showButton();
        }
        prev.onclick = function () {
            if (animated) {
                return;
            }
            if (index == 1) {
                index = 5;
            }
            else {
                index -= 1;
            }
            animate(960);
            showButton();
        }

        for (var i = 0; i < buttons.length; i++) {
            buttons[i].onclick = function () {
                if (animated) {
                    return;
                }
                if(this.className == 'on') {
                    return;
                }
                var myIndex = parseInt(this.getAttribute('index'));
                var offset = -960 * (myIndex - index);

                animate(offset);
                index = myIndex;
                showButton();
            }
        }

        container.onmouseover = stop;
        container.onmouseout = play;

        play();

    }
</script>