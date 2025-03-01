import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CommonModule } from '@angular/common';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, FormControl } from '@angular/forms';

import { NavbarComponent } from './navbar/navbar.component';
import { FooterComponent } from './footer/footer.component';
import { IndexComponent } from './index/index.component';
import { AboutComponent } from './about/about.component';
import { LoginComponent } from './login/login.component';
import { ContactComponent } from './contact/contact.component';
import { GalleryComponent } from './gallery/gallery.component';
import { NotaOrderComponent } from './nota-order/nota-order.component';
import { BlogComponent } from './blog/blog.component';
import { SignupComponent } from './signup/signup.component';
import { ShopComponent } from './shop/shop.component';
import { DetailProdukComponent } from './detail-produk/detail-produk.component';
import { PembayaranComponent } from './pembayaran/pembayaran.component';
import { KonfirmasiPembayaranComponent } from './konfirmasi-pembayaran/konfirmasi-pembayaran.component';
import { OrderanComponent } from './orderan/orderan.component';
import { CheckoutComponent } from './checkout/checkout.component';
import { CartComponent } from './cart/cart.component';
import { DetailBlogComponent } from './detail-blog/detail-blog.component';
import { LupaPasswordComponent } from './lupa-password/lupa-password.component';
import { RincianProdukComponent } from './rincian-produk/rincian-produk.component';

export const routes: Routes = [
    { path: '', component: IndexComponent },
    { path: 'about', component: AboutComponent },
    { path: 'login', component: LoginComponent },
    { path: 'lupa-password', component: LupaPasswordComponent },
    { path: 'contact', component: ContactComponent },
    { path: 'gallery', component: GalleryComponent },
    { path: 'blog', component: BlogComponent },
    { path: 'signup', component: SignupComponent },
    { path: 'shop', component: ShopComponent },
    { path: 'product/:id', component: DetailProdukComponent },
    { path: 'nota-order/:id', component: NotaOrderComponent },
    { path: 'payment/:id', component: PembayaranComponent },
    { path: 'konfirmasi-pembayaran/:id', component: KonfirmasiPembayaranComponent },
    { path: 'orderan', component: OrderanComponent },
    { path: 'checkout', component: CheckoutComponent },
    { path: 'cart', component: CartComponent },
    { path: 'blog/:id', component: DetailBlogComponent },
    { path: 'rincian-produk/:id', component: RincianProdukComponent },
];

@NgModule({
    imports: [RouterModule.forRoot(routes), CommonModule, BrowserModule],
    exports: [RouterModule]
})
export class AppRoutingModule { }