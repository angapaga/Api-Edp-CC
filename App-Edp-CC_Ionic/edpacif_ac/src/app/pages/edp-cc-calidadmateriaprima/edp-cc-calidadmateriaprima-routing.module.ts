import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcCalidadmateriaprimaPage } from './edp-cc-calidadmateriaprima.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcCalidadmateriaprimaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcCalidadmateriaprimaPageRoutingModule {}
