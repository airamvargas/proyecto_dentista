<style>
  .sl-menu-sub .nav-link {
    padding-left: 4px !important;
  }
</style>
<!-- ########## START: LEFT PANEL ########## -->
<div class="sl-logo">
  <a href="<?= base_url() ?>">
    <div><img src="<?= base_url() ?>/../../assets/img/doisy_white.png" height="100%" width="100%"></div>
  </a>  
</div>
<div class="sl-sideleft">
  <!-- <div class="input-group input-group-search">
    <input type="search" name="search" class="form-control" placeholder="Search">
    <span class="input-group-btn">
      <button class="btn"><i class="fa fa-search"></i></button>
    </span>
  </div> -->

  <div class="sl-sideleft-menu">
    <table>
      <?php foreach ($menu as $item) : ?>
        <a href="index.html" class="sl-menu-link show-sub">
          <div class="sl-menu-item" style="background-color: #2b333e; color: white;">
            <?= $item['icon'] ?>
            <span class="menu-item-label"><?= $item['name'] ?></span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column" style="display: block; background-color: #2b333e;">
          <?php foreach ($item['subModules'] as $sub) : ?>
            <li class="nav-item"><a href="<?= base_url() . "/" . $sub->controller ?>" class="nav-link"><?= $sub->name ?></a></li>
          <?php endforeach; ?>
        </ul>
      <?php endforeach; ?>
    </table>

  </div><!-- sl-sideleft-menu -->

  
</div><!-- sl-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->