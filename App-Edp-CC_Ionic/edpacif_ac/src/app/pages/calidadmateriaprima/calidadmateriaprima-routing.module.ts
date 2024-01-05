import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CalidadmateriaprimaPage } from './calidadmateriaprima.page';

const routes: Routes = [
  {
    path: '',
    component: CalidadmateriaprimaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CalidadmateriaprimaPageRoutingModule {}
