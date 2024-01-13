import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcRemuestrafisicapendientesPage } from './edp-cc-remuestrafisicapendientes.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcRemuestrafisicapendientesPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcRemuestrafisicapendientesPageRoutingModule {}
