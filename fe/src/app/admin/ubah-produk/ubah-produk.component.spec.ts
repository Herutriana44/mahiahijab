import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UbahProdukComponent } from './ubah-produk.component';

describe('UbahProdukComponent', () => {
  let component: UbahProdukComponent;
  let fixture: ComponentFixture<UbahProdukComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [UbahProdukComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UbahProdukComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
