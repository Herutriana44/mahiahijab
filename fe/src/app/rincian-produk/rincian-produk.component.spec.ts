import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RincianProdukComponent } from './rincian-produk.component';

describe('RincianProdukComponent', () => {
  let component: RincianProdukComponent;
  let fixture: ComponentFixture<RincianProdukComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RincianProdukComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RincianProdukComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
