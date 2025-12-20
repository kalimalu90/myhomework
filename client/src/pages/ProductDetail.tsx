import { useTranslation } from "@/contexts/LocalizationContext";
import { trpc } from "@/lib/trpc";
import { Button } from "@/components/ui/button";
import { useLocation, useRoute } from "wouter";
import { Loader2, ArrowLeft } from "lucide-react";

export default function ProductDetail() {
  const { t } = useTranslation();
  const [, navigate] = useLocation();
  const [match, params] = useRoute("/products/:id");

  const productId = params?.id ? parseInt(params.id) : null;
  const { data: product, isLoading } = trpc.products.get.useQuery(
    productId || 0,
    { enabled: !!productId }
  );

  if (!match) return null;

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <Loader2 className="animate-spin w-8 h-8" />
      </div>
    );
  }

  if (!product) {
    return (
      <div className="min-h-screen bg-background py-8">
        <div className="container mx-auto px-4 text-center">
          <p className="text-muted-foreground text-lg mb-4">
            Product not found
          </p>
          <Button onClick={() => navigate("/products")}>
            {t("product.back")}
          </Button>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background py-8">
      <div className="container mx-auto px-4 max-w-2xl">
        <Button
          variant="ghost"
          onClick={() => navigate("/products")}
          className="mb-6"
        >
          <ArrowLeft className="w-4 h-4 mr-2" />
          {t("product.back")}
        </Button>

        <div className="bg-card rounded-lg overflow-hidden border border-border">
          {product.image && (
            <div className="aspect-video overflow-hidden bg-muted">
              <img
                src={product.image}
                alt={product.name}
                className="w-full h-full object-cover"
              />
            </div>
          )}

          <div className="p-8">
            <h1 className="text-4xl font-bold text-foreground mb-4">
              {product.name}
            </h1>

            <div className="space-y-4">
              <div>
                <h2 className="text-lg font-semibold text-foreground mb-2">
                  {t("products.description")}
                </h2>
                <p className="text-muted-foreground whitespace-pre-wrap">
                  {product.description}
                </p>
              </div>

              {product.createdAt && (
                <div className="text-sm text-muted-foreground pt-4 border-t border-border">
                  <p>
                    Created:{" "}
                    {new Date(product.createdAt).toLocaleDateString()}
                  </p>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
