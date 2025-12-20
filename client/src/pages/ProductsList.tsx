import { useTranslation } from "@/contexts/LocalizationContext";
import { trpc } from "@/lib/trpc";
import { Button } from "@/components/ui/button";
import { Link } from "wouter";
import { Loader2 } from "lucide-react";

export default function ProductsList() {
  const { t } = useTranslation();
  const { data: products, isLoading } = trpc.products.list.useQuery();

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <Loader2 className="animate-spin w-8 h-8" />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background py-8">
      <div className="container mx-auto px-4">
        <div className="flex justify-between items-center mb-8">
          <h1 className="text-3xl font-bold text-foreground">
            {t("products.title")}
          </h1>
          <Link href="/create">
            <Button>{t("nav.addProduct")}</Button>
          </Link>
        </div>

        {!products || products.length === 0 ? (
          <div className="text-center py-12">
            <p className="text-muted-foreground text-lg mb-4">
              {t("products.noProducts")}
            </p>
            <Link href="/create">
              <Button>{t("products.addNew")}</Button>
            </Link>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {products.map((product) => (
              <div
                key={product.id}
                className="border border-border rounded-lg overflow-hidden hover:shadow-lg transition-shadow"
              >
                <div className="aspect-square overflow-hidden bg-muted">
                  {product.image && (
                    <img
                      src={product.image}
                      alt={product.name}
                      className="w-full h-full object-cover hover:scale-105 transition-transform"
                    />
                  )}
                </div>
                <div className="p-4">
                  <h2 className="text-lg font-semibold text-foreground mb-2">
                    {product.name}
                  </h2>
                  <p className="text-sm text-muted-foreground mb-4 line-clamp-2">
                    {product.description}
                  </p>
                  <Link href={`/products/${product.id}`}>
                    <Button className="w-full">{t("products.view")}</Button>
                  </Link>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
