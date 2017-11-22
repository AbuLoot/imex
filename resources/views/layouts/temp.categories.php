          <ul class="nav nav-pills nav-justified collapse navigation-collapse categories" id="collapseAutoParts">
            <?php $traverse = function ($categories, $uri = '') use (&$traverse) { ?>
              <?php foreach ($categories as $category) : ?>
                <li>
                  <?php if ($category->isRoot()) $uri = ''; ?>
                  <?php if (count($category->descendants()->get()) > 0) : ?>
                    <a href="#">{{ $category->title }}</a>
                  <?php else : ?>
                    <a href="/catalog/{{ $uri.$category->slug }}">{{ $category->title }}</a>
                  <?php endif; ?>
                  <?php if ($category->children && count($category->children) > 1) : ?>
                    <ul class="subcategories">
                      <?php $traverse($category->children, $uri .= $category->slug.'/'); ?>
                    </ul>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            <?php }; $traverse($categories); ?>
          </ul>