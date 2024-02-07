<ul class="nav nav-tabs"> 
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Kunden</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Kunden</button>
                <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15): ?>
                    <ul class="dropdown-menu" style="background-color: ">
                        <li class="dropdown-header">in Bearbeitung</li>
                    <li><a href="/kunden/<?php echo e(session('customerID')); ?>">aktiver Kunde</a></li>
                        <li class="dropdown-header">Verwaltung</li>
                        <li><a href="/kunden">Übersicht</a></li>
                        <li><a href="/kunden/create">anlegen</a></li>
                        
                    </ul>
                <?php endif; ?>
            </div>
        </li>
        <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16): ?>
            <button class="btn btn-warning"><a href="/kunden/<?php echo e(session('customerID')); ?>">aktiver Kunde</a></button>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Projekte & Fluggeräte</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Projekte & Fluggeräte</button>
                <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16): ?>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Projekte</li>
                        <li><a href="/projekte">Übersicht</a></li>
                        <li><a href="/projekte/create">anlegen</a></li>
                        <li class="dropdown-header">Fluggeraete</li>
                        <li><a href="/fluggeraete">Übersicht</a></li>
                        <li><a href="/fluggeraete/create">anlegen</a></li>
                        
                    </ul>
                <?php endif; ?>
            </div>
        </li>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Aufträge</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Aufträge</button>
                <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16): ?>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">alle Aufträge</li>
                        <li><a href="/auftraege">Übersicht</a></li>
                        <li class="dropdown-header">aktueller Auftrag</li>
                        <a id="dropdown" href="<?php echo e(route('cart.index')); ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Artikelkorb <span class="oi" data-glyph="cart" title="bearbeiten" aria-hidden="true"></span> <?php echo e(\Cart::getTotalQuantity()); ?>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 450px; padding: 0px; border-color: #9DA0A2">
                            <ul class="list-group" style="margin: 20px;">
                                <?php echo $__env->make('internals.cart-drop', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </ul>
                        </div>
                        <li class="dropdown-header">ESPData</li>
                        <li><a href="/espData">Übersicht</a></li>
                        
                        
                    </ul>
                <?php endif; ?>
            </div>
        </li>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller & Zubehör</button>
        </div>
    </li>
    <?php else: ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller & Zubehör</button>
            <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16): ?> 
                <ul class="dropdown-menu">
                    <li class="dropdown-header">Propeller</li>
                    <li><a href="/propeller">Übersicht</a></li>
                    <li><a href="/propeller/create">anlegen</a></li>
                    <li class="dropdown-header">Zubehör</li>
                    <li><a href="/shop">Übersicht</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </li>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller Tools, Matrix & CAD</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller Tools, Matrix & CAD</button>
                <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16): ?> 
                    <ul class="dropdown-menu">
                        
                        <li class="dropdown-header">Matrix</li>
                        <li><a href="/propellerFormMatritzen">Übersicht</a></li>
                        <li><a href="/propellerFormen">Formen</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">CAD-Daten</li>
                        <li><a href="/propellerModellBlattTypen">Typen</a></li>
                        <li><a href="/propellerModellKompatibilitaeten">Kompatibilitaeten</a></li>
                        <li><a href="/propellerModellWurzeln">Modell Wurzeln</a></li>
                        <li><a href="/propellerModellBlaetter">Modell Blätter</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">Zuschnitte</li>
                        <li><a href="/propellerZuschnitte">Übersicht</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">StepCode</li>
                        <li><a href="/propellerStepCode">Dashboard</a></li>
                        
                        
                    </ul>
                <?php endif; ?>
                <?php if(Auth::user()->id == 13 || Auth::user()->id == 14 || Auth::user()->id == 15 && Auth::user()->id != 16): ?> 
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Matrix</li>
                        <li><a href="/propellerFormMatritzen">Übersicht</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Motoren, Getriebe & Flansche</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Motoren, Getriebe & Flansche</button>
                <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16): ?>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Motoren</li>
                        <li><a href="/motoren">Übersicht</a></li>
                        <li><a href="/motoren/create">anlegen</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">Getriebe</li>
                        <li><a href="/motorGetriebe">Übersicht</a></li>
                        <li><a href="/motorGetriebe/create">anlegen</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">Flansche</li>
                        <li><a href="/motorFlansche">Übersicht</a></li>
                        <li><a href="/motorFlansche/create">anlegen</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Produktion</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Produktion</button>
                <?php if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16): ?>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Materialien & Hersteller</li>
                        <li><a href="/materialien">Materialien</a></li>
                        <li><a href="/materialHersteller">Hersteller</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">LFA</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">LFA</button>
                <?php if(Auth::user()->id == 1 || Auth::user()->id == 7): ?>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Lärmmessungen</li>
                        <li><a href="/laermmessungen">Übersicht</a></li>
                        <li><a href="/laermmessungen/create">Eingabe</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown mr-2">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Q13</button>
        </div>
    </li>
    <?php else: ?>
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Q13</button>
                <?php if(Auth::user()->id == 1 || Auth::user()->id == 7): ?>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Nullpunkte</li>
                        <li><a href="/q13Nullpunkte">Übersicht</a></li>
                        <li><a href="/q13Nullpunkte/create">Eingabe</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
    <?php endif; ?>
    <!-- Authentication Links -->
    <?php if(auth()->guard()->guest()): ?>
    <li class="nav-item dropdown">
        <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Benutzer
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a></li>
                <!-- <?php if(Route::has('register')): ?>        
                    <li><a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a></li>
                <?php endif; ?> -->
                <?php else: ?>
                <button class="btn btn-warning"><a href="/dashboard">Dashboard</a></button>
                <li class="dropdown">
                    <a id="navbarDropdown" class="btn btn-success dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                    </a>
                    
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        
                        <li><a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <?php echo e(__('Logout')); ?>

                        </a></li>
        
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </ul>
                </li>
    <?php endif; ?>   
            </ul>
        </div>
    </li>
</ul><?php /**PATH C:\Users\User\sources\KVA\resources\views/internals/nav.blade.php ENDPATH**/ ?>