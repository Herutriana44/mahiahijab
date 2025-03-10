import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminUbahProdukComponent } from './ubah-produk.component';

describe('UbahProdukComponent', () => {
  let component: AdminUbahProdukComponent;
  let fixture: ComponentFixture<AdminUbahProdukComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminUbahProdukComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AdminUbahProdukComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
