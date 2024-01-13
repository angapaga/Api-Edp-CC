import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcCabezascargadasPage } from './edp-cc-cabezascargadas.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcCabezascargadasPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcCabezascargadasPageRoutingModule {}
