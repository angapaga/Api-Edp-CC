import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CalidadproductoprocesoPage } from './calidadproductoproceso.page';

const routes: Routes = [
  {
    path: '',
    component: CalidadproductoprocesoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CalidadproductoprocesoPageRoutingModule {}
