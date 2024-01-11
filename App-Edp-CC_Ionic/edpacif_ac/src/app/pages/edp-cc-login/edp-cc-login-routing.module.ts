import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcLoginPage } from './edp-cc-login.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcLoginPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcLoginPageRoutingModule {}
