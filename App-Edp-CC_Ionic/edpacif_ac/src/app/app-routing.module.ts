import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'home',
    loadChildren: () => import('./pages/home/home.module').then( m => m.HomePageModule)
  },
  {
    path: '',
    redirectTo: 'menu',
    pathMatch: 'full'
  },
  {
    path: 'login',
    loadChildren: () => import('./pages/login/login.module').then( m => m.LoginPageModule)
  },
  {
    path: 'menu',
    loadChildren: () => import('./pages/menu/menu.module').then( m => m.MenuPageModule)
  },
  {
    path: 'calidadmateriaprima',
    loadChildren: () => import('./pages/calidadmateriaprima/calidadmateriaprima.module').then( m => m.CalidadmateriaprimaPageModule)
  },
  {
    path: 'calidadproductoproceso',
    loadChildren: () => import('./pages/calidadproductoproceso/calidadproductoproceso.module').then( m => m.CalidadproductoprocesoPageModule)
  },
  {
    path: 'calidadproductoterminado',
    loadChildren: () => import('./pages/calidadproductoterminado/calidadproductoterminado.module').then( m => m.CalidadproductoterminadoPageModule)
  },
  {
    path: 'panelsabor',
    loadChildren: () => import('./pages/panelsabor/panelsabor.module').then( m => m.PanelsaborPageModule)
  },
  
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
