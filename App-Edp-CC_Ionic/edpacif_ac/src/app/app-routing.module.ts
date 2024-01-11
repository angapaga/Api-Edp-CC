import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'home',
    loadChildren: () => import('./pages/home/home.module').then( m => m.HomePageModule)
  },
  {
    path: '',
    redirectTo: 'edp-cc-start',
    pathMatch: 'full'
  },
  {
    path: 'edp-cc-panelespendientes',
    loadChildren: () => import('./pages/edp-cc-panelespendientes/edp-cc-panelespendientes.module').then( m => m.EdpCcPanelespendientesPageModule)
  },
  {
    path: 'edp-cc-calidadmateriaprima',
    loadChildren: () => import('./pages/edp-cc-calidadmateriaprima/edp-cc-calidadmateriaprima.module').then( m => m.EdpCcCalidadmateriaprimaPageModule)
  },
  {
    path: 'edp-cc-start',
    loadChildren: () => import('./pages/edp-cc-start/edp-cc-start.module').then( m => m.EdpCcStartPageModule)
  },
  {
    path: 'edp-cc-panelsabor',
    loadChildren: () => import('./pages/edp-cc-panelsabor/edp-cc-panelsabor.module').then( m => m.EdpCcPanelsaborPageModule)
  },
  {
    path: 'edp-cc-login',
    loadChildren: () => import('./pages/edp-cc-login/edp-cc-login.module').then( m => m.EdpCcLoginPageModule)
  },
  {
    path: 'edp-cc-home',
    loadChildren: () => import('./pages/edp-cc-home/edp-cc-home.module').then( m => m.EdpCcHomePageModule)
  },
  {
    path: 'edp-cc-inicio',
    loadChildren: () => import('./edp-cc-inicio/edp-cc-inicio.module').then( m => m.EdpCcInicioPageModule)
  },

];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
