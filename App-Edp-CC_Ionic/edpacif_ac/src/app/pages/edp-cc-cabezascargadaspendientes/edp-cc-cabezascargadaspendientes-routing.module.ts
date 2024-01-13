import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcCabezascargadaspendientesPage } from './edp-cc-cabezascargadaspendientes.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcCabezascargadaspendientesPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcCabezascargadaspendientesPageRoutingModule {}
