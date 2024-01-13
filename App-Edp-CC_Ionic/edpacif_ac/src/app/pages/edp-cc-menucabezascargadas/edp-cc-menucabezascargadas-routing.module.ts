import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcMenucabezascargadasPage } from './edp-cc-menucabezascargadas.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcMenucabezascargadasPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcMenucabezascargadasPageRoutingModule {}
