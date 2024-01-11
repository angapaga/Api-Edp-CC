import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcInicioPage } from './edp-cc-inicio.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcInicioPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcInicioPageRoutingModule {}
