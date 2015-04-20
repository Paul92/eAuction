<script>
  document.write('<script src=<?php echo ROOT_URL;?>/imageViewer/PhotoSwipe/dist/photoswipe.js?r='+Math.random()+'><\/script>');
  document.write('<script src=<?php echo ROOT_URL;?>/imageViewer/PhotoSwipe/dist/photoswipe-ui-default.js?r='+Math.random()+'><\/script>');
</script>  

<script>try{Typekit.load();}catch(e){}</script>
<div class="container">
  <h1 class="page-header"> <?php
    echo $item['name'];
    echo '</h1>';
    if (isset($error) && !empty($error)) {
      echo '<div class="alert alert-danger" role="alert">';
      echo '<span class="glyphicon glyphicon-exclamation-sign"';
      echo 'aria-hidden="true"> </span>';
      echo '<a class="close" data-dismiss="alert">×</a>';
      echo '<span class="sr-only">Error: </span>';
      echo '<strong> Error: </strong>' . $error;
      echo '</div>';
    }?>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div id="demo-test-gallery" class="demo-gallery">
        <?php foreach ($images as $image) {
        echo '<a href="' . ROOT_URL . '/' . $image['filePath'] . '" data-size="';
        echo $image['size'] . '" data-med="' . ROOT_URL . '/' . $image['thumbnailPath'];
        echo '" data-med-size="' . $image['thumbnailSize'] . '" ';
        if ($image['main'] == 1)
            echo 'class="demo-gallery__img--main"';
        echo '>';
        echo '<img src="' . ROOT_URL . '/' . $image['thumbnailPath'] . '" alt="" /></a>' . "\n";
        }?>
      </div>

    <div id="gallery" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip">
              <a href="#" class="pswp__share--twitter"></a>
              <a href="#" class="pswp__share--pinterest"></a>
              <a href="#" download class="pswp__share--download"></a> -->
            </div>
          </div>

          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
          <div class="pswp__caption">
            <div class="pswp__caption__center"> </div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xs-12">
        <table class="table">
          <tr>
            <td>
              <label>Seller nickname:</label>
            </td>
            <td>
              <label><a href="<?php echo ROOT_URL . "/dashboard/viewProfile/" . $item['sellerId'];?>">John</a></label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Seller rating:</label>
            </td>
            <td>
              <label><?php echo $item['sellerRating'];?></label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Auction end date:</label>
            </td>
            <td>
              <label><?php echo $item['endDate'];?></label>
            </td>
            <td>
              <?php echo '<span class="col-xs-12 label label-';
              if ($item['finished'] == 1) {
                  echo "danger\">Closed</span>\n";
              } else {
                  echo "success\">Open</span>\n"; 
              }?>
            </td>
          </tr>
          <tr>
            <td>
              <?php if ($item['auctionTypeId'] != 5): ?>
                  <label>Auction start price:</label>
              <?php else: ?>
                  <label>Item price:</label>
              <?php endif;?>
            </td>
            <td>
              <label>&pound;<?php echo $item['startPrice'];?></label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Product category:</label>
            </td>
            <td>
              <label><a href="<?php echo ROOT_URL;?>/index/category/<?php 
                                    echo $item['categoryId']?>"><?php
                                    echo $item['category'];?></a></label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Auction type:</label>
            </td>
            <td>
              <label><?php echo $item['auctionType'];?></label>
            </td>
            <td></td>
          </tr>
          <?php if ($item['auctionTypeId'] == 1): ?>
          <tr>
            <td>
              <label>Current maximum bid:</label>
            </td>
            <td>
              <label>
                <?php
                  if ($item['maxBid'] == null)
                      echo 'No bids';
                  else
                      echo '&pound;'  . $item['maxBid']?>
              </label>
            </td>
            <td></td>
          </tr>
          <?php elseif ($item['auctionTypeId'] == 2 && $item['finished'] == 0): ?>
          <tr>
            <td>
              <label>Current price:</label>
            </td>
            <td>
              <label>
                <?php echo '&pound;'  . $item['currentPrice']?>
              </label>
            </td>
            <td></td>
          </tr>
          <?php endif;?>
          <?php if (Session::exists('loggedIn') && $item['finished'] == 0): ?>
          <tr>
              <?php if ($item['auctionTypeId'] != 5 &&
                        $item['auctionTypeId'] != 2): ?>
              <form class="form-horizontal" method="post"
                   action="<?php echo ROOT_URL . '/item/bid/' . $item['id'];?>">
                <input type="hidden" name="itemId"
                       value="<?php echo $item['id']?>">
                <input type="hidden" name="auctionType"
                       value="<?php echo $item['auctionTypeId']?>">
                <input type="hidden" name="startPrice"
                       value="<?php echo $item['startPrice']?>">
                <td> <label>Bid value (&pound;):</label> </td>
                <td>
                <input type="text" class="form-control"
                       id="bidValue" name="bidValue">
                </td>
                <td>
                  <button type="submit" class="btn btn-primary">
                    Bid Now
                  </button>
                </td>
              </form>
              <?php else: ?>
              <form class="form-horizontal" method="post"
                   action="<?php echo ROOT_URL . '/item/buy/' . $item['id'];?>">
                <input type="hidden" name="sellerId"
                       value="<?php echo $item['sellerId']?>">
                  <input type="hidden" name="price"
                <?php if ($item['auctionTypeId'] == 2): ?>
                         value="<?php echo $item['currentPrice']?>">
                <?php else:?>
                         value="<?php echo $item['startPrice']?>">
                <?php endif;?>
                <input type="hidden" name="itemName"
                       value="<?php echo $item['name']?>">
                <td><td>
                <td>
                  <button type="submit" class="btn btn-primary">
                    Buy Now
                  </button>
                </td>
              </form>
              <?php endif; ?>
            <td></td>
          </tr>
          <?php endif;?>
        </table>
    </div>
  </div>
  <div class="top10 row">
    <h2>
      Product description
    </h2>
    <hr>
    <p>
    <?php echo $item['description'];?>
    </p>
  </div>
</div>
    <script type="text/javascript">
    (function() {

        var initPhotoSwipeFromDOM = function(gallerySelector) {

            var parseThumbnailElements = function(el) {
                var thumbElements = el.childNodes,
                    numNodes = thumbElements.length,
                    items = [],
                    el,
                    childElements,
                    thumbnailEl,
                    size,
                    item;

                for(var i = 0; i < numNodes; i++) {
                    el = thumbElements[i];

                    // include only element nodes 
                    if(el.nodeType !== 1) {
                      continue;
                    }

                    childElements = el.children;

                    size = el.getAttribute('data-size').split('x');

                    // create slide object
                    item = {
                        src: el.getAttribute('href'),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10),
                        author: el.getAttribute('data-author')
                    };

                    item.el = el; // save link to element for getThumbBoundsFn

                    if(childElements.length > 0) {
                      item.msrc = childElements[0].getAttribute('src'); // thumbnail url
                      if(childElements.length > 1) {
                          item.title = childElements[1].innerHTML; // caption (contents of figure)
                      }
                    }


                    var mediumSrc = el.getAttribute('data-med');
                      if(mediumSrc) {
                        size = el.getAttribute('data-med-size').split('x');
                        // "medium-sized" image
                        item.m = {
                              src: mediumSrc,
                              w: parseInt(size[0], 10),
                              h: parseInt(size[1], 10)
                        };
                      }
                      // original image
                      item.o = {
                          src: item.src,
                          w: item.w,
                          h: item.h
                      };

                    items.push(item);
                }

                return items;
            };

            // find nearest parent element
            var closest = function closest(el, fn) {
                return el && ( fn(el) ? el : closest(el.parentNode, fn) );
            };

            var onThumbnailsClick = function(e) {
                e = e || window.event;
                e.preventDefault ? e.preventDefault() : e.returnValue = false;

                var eTarget = e.target || e.srcElement;

                var clickedListItem = closest(eTarget, function(el) {
                    return el.tagName === 'A';
                });

                if(!clickedListItem) {
                    return;
                }

                var clickedGallery = clickedListItem.parentNode;

                var childNodes = clickedListItem.parentNode.childNodes,
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;

                for (var i = 0; i < numChildNodes; i++) {
                    if(childNodes[i].nodeType !== 1) { 
                        continue; 
                    }

                    if(childNodes[i] === clickedListItem) {
                        index = nodeIndex;
                        break;
                    }
                    nodeIndex++;
                }

                if(index >= 0) {
                    openPhotoSwipe( index, clickedGallery );
                }
                return false;
            };

            var photoswipeParseHash = function() {
                var hash = window.location.hash.substring(1),
                params = {};

                if(hash.length < 5) { // pid=1
                    return params;
                }

                var vars = hash.split('&');
                for (var i = 0; i < vars.length; i++) {
                    if(!vars[i]) {
                        continue;
                    }
                    var pair = vars[i].split('=');  
                    if(pair.length < 2) {
                        continue;
                    }           
                    params[pair[0]] = pair[1];
                }

                if(params.gid) {
                    params.gid = parseInt(params.gid, 10);
                }

                if(!params.hasOwnProperty('pid')) {
                    return params;
                }
                params.pid = parseInt(params.pid, 10);
                return params;
            };

            var openPhotoSwipe = function(index, galleryElement, disableAnimation) {
                var pswpElement = document.querySelectorAll('.pswp')[0],
                    gallery,
                    options,
                    items;

                items = parseThumbnailElements(galleryElement);

                // define options (if needed)
                options = {
                    index: index,

                    galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                    getThumbBoundsFn: function(index) {
                        // See Options->getThumbBoundsFn section of docs for more info
                        var thumbnail = items[index].el.children[0],
                            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect(); 

                        return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                    },

                    addCaptionHTMLFn: function(item, captionEl, isFake) {
                        if(!item.title) {
                            captionEl.children[0].innerText = '';
                            return false;
                        }
                        captionEl.children[0].innerHTML = item.title +  '<br/><small>Photo: ' + item.author + '</small>';
                        return true;
                    }
                    
                };

                var radios = document.getElementsByName('gallery-style');
                for (var i = 0, length = radios.length; i < length; i++) {
                    if (radios[i].checked) {
                        if(radios[i].id == 'radio-all-controls') {

                        } else if(radios[i].id == 'radio-minimal-black') {
                            options.mainClass = 'pswp--minimal--dark';
                            options.barsSize = {top:0,bottom:0};
                            options.captionEl = false;
                            options.fullscreenEl = false;
                            options.shareEl = false;
                            options.bgOpacity = 0.85;
                            options.tapToClose = true;
                            options.tapToToggleControls = false;
                        }
                        break;
                    }
                }

                if(disableAnimation) {
                    options.showAnimationDuration = 0;
                }

                // Pass data to PhotoSwipe and initialize it
                gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);

                // see: http://photoswipe.com/documentation/responsive-images.html
                var realViewportWidth,
                    useLargeImages = false,
                    firstResize = true,
                    imageSrcWillChange;

                gallery.listen('beforeResize', function() {

                    var dpiRatio = window.devicePixelRatio ? window.devicePixelRatio : 1;
                    dpiRatio = Math.min(dpiRatio, 2.5);
                    realViewportWidth = gallery.viewportSize.x * dpiRatio;


                    if(realViewportWidth >= 1200 || (!gallery.likelyTouchDevice && realViewportWidth > 800) || screen.width > 1200 ) {
                        if(!useLargeImages) {
                            useLargeImages = true;
                            imageSrcWillChange = true;
                        }
                        
                    } else {
                        if(useLargeImages) {
                            useLargeImages = false;
                            imageSrcWillChange = true;
                        }
                    }

                    if(imageSrcWillChange && !firstResize) {
                        gallery.invalidateCurrItems();
                    }

                    if(firstResize) {
                        firstResize = false;
                    }

                    imageSrcWillChange = false;

                });

                gallery.listen('gettingData', function(index, item) {
                    if( useLargeImages ) {
                        item.src = item.o.src;
                        item.w = item.o.w;
                        item.h = item.o.h;
                    } else {
                        item.src = item.m.src;
                        item.w = item.m.w;
                        item.h = item.m.h;
                    }
                });

                gallery.init();
            };

            // select all gallery elements
            var galleryElements = document.querySelectorAll( gallerySelector );
            for(var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute('data-pswp-uid', i+1);
                galleryElements[i].onclick = onThumbnailsClick;
            }

            // Parse URL and open gallery if it contains #&pid=3&gid=1
            var hashData = photoswipeParseHash();
            if(hashData.pid > 0 && hashData.gid > 0) {
                openPhotoSwipe( hashData.pid - 1 ,  galleryElements[ hashData.gid - 1 ], true );
            }
        };

        initPhotoSwipeFromDOM('.demo-gallery');

    })();

    </script>
